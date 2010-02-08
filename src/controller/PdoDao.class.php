<?php
/*
Copyright (c) 2010 Marco Aurélio Graciotto Silva <magsilva@ironiacorp.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/


require_once('controller/PdoDatabase.class.php');
require_once('controller/Dao.interface.php');

abstract class PdoDao extends PdoDatabase implements Dao
{
	public function __construct($db_url, $db_user, $db_password)
	{
		parent::__construct($db_url, $db_user, $db_password);
	}

	protected function getType()
	{
		$class = get_class($this);
		$type = str_replace('PdoDao', '', $class);
		return $type;		
	}

	protected function getTableName()
	{
		$type = $this->getType();
		$table = strtolower($type) . 's';
		return $table;		
	}
	
	protected function getColumnName($property)
	{
		$name = '';
		for ($i = 1; $i < strlen($property); $i++) {
			if ($property[$i] == strtoupper($property[$i])) {
				$name .= '_' . strtolower($property[$i]);
			}
		}
		
		return $name;
	}

	protected function getPropertyName($column)
	{
		$parts = explode('_', $column);
		$name = $parts[0];
		for ($i = 1; $i < count($parts); $i++) {
			$name .= ucfirst($parts[$i]);
		}
		
		return $name;
	}
	
	
	public function create($data)
	{
		$table = $this->getTableName();
		
		$stmt = 'INSERT INTO ' . $table . '(';
		foreach ($data as $key => $value) {
			$column = $this->getColumnName($key);
			$stmt .= $column . ', ';
		}
		$stmt = substr($stmt, 0, strlen($stmt) - 2);
		
		$stmt .= ') VALUES (';
		foreach ($data as $key => $value) {
			$column = $this->getColumnName($key);
			$stmt .= ':' . $column . ', ';
		}
		$stmt = substr($stmt, 0, strlen($stmt) - 2);
		$stmt .= ')';
		
		$this->beginTransaction();
		$sth = $this->prepare($stmt);
		
		foreach($data as $key => $value) {
			$column = $this->getColumnName($key);
			$sth->bindValue(':' . $column, $value);
		}
		$sth->execute();
		$this->commit();
		
		return $this->lastInsertId();
	}
		
	
	public function read($id)
	{
		$type = $this->getType();
		$table = $this->getTableName();
		
		$this->beginTransaction();
		$sth = $this->prepare('SELECT * FROM ' . $table . ' WHERE id=:id');
		$sth->bindValue(':id', $id);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$this->commit();
		
		if ($result === FALSE) {
			return null;
		}
		
		$class = new ReflectionClass($type);
		$properties = $class->getProperties();
		$args = array();
		foreach ($result as $key => $value) {
			$property = $this->getPropertyName($key);
			if ($class->hasProperty($property) && $class->hasMethod('get' . ucfirst($property))) {
			 	if (strpos($property, 'id') !== FALSE || ! $class->hasMethod('set' . ucfirst($property))) {
					$args[] = $value;
				} 	
			}
		}
		
		$object = $class->newInstanceArgs($args);
		foreach ($result as $key => $value) {
			$property = $this->getPropertyName($key);
			$method_name = 'set' . ucfirst($property);
			if ($class->hasMethod($method_name)) {
				$method = new ReflectionMethod($type, $method_name);
				if ($method->isPublic()) { 
					$method->invoke($object, $value);
				}
			}
		}
		
		return $object;
	}
	
	public function update($object)
	{
		$type = $this->getType();
		$table = $this->getTableName();
		
		$this->beginTransaction();
		$stmt = 'UPDATE ' . $table . ' SET ';
	
		$class = new ReflectionClass($type);
		$properties = $class->getProperties();
		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get' . $property->getName()) && $class->hasMethod('set' . $property->getName())) {
				$column_name = $this->getColumnName($property->getName());
				$stmt .= $column_name . '=:' . $column_name . ', '; 	
			}
		}
		if (strpos($stmt, ', ', strlen($stmt) - 2)) {
			$stmt = substr($stmt, 0, strlen($stmt) - 2);
		}
		
		$stmt .= ' WHERE ';
		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get' . $property->getName()) && ! $class->hasMethod('set' . $property->getName())) {
				$column_name = $this->getColumnName($property->getName());
				$stmt .= $column_name . '=:' . $column_name . ' AND '; 	
			}
		}
		if (strpos($stmt, ' AND ', strlen($stmt) - 5)) {
			$stmt = substr($stmt, 0, strlen($stmt) - 5);
		}
		
		$sth = $this->prepare($stmt);

		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get' . $property->getName())) {
				$method = $class->getMethod('get' . $property->getName());
				$value = $method->invoke($object);
				$column_name = $this->getColumnName($property->getName());
				$sth->bindValue(':' . $column_name, $value);
			}
		}

		$result = $sth->execute();
		if ($result == FALSE || $sth->rowCount() != 1) {
			// TODO: Improve error handling var_dump('Error running SQL prepared statement', $result, $sth->rowCount(), $stmt);
		}
		$this->commit();
	}
	
	public function delete($object)
	{
		$table = $this->getTableName();
		
		$this->beginTransaction();
		$sth = $this->prepare('DELETE FROM ' . $table . ' WHERE id=:id');
		$sth->bindValue(':id', $object->getId());
		$sth->execute();
		$this->commit();
	}
	
	
	public function findAll()
	{
		$table = $this->getTableName();
		$type = $this->getType();
		$result = array();
		
		$this->beginTransaction();
		$sth = $this->prepare('SELECT * FROM ' . $table);
		$sth->execute();
		$rowset = $sth->fetchAll(PDO::FETCH_ASSOC);
		$this->commit();
		if ($rowset === FALSE) {
			return $result;
		}
		
		
		foreach ($rowset as $row) {
			$class = new ReflectionClass($type);
			$properties = $class->getProperties();
			$args = array();
			foreach ($row as $key => $value) {
				$property = $this->getPropertyName($key);
				if ($class->hasProperty($property) && $class->hasMethod('get' . ucfirst($property))) {
				 	if (strpos($property, 'id') !== FALSE || ! $class->hasMethod('set' . ucfirst($property))) {
						$args[] = $value;
					} 	
				}
			}
			
			$object = $class->newInstanceArgs($args);
			foreach ($row as $key => $value) {
				$property = $this->getPropertyName($key);
				$method_name = 'set' . ucfirst($property);
				if ($class->hasMethod($method_name)) {
					$method = new ReflectionMethod($type, $method_name);
					if ($method->isPublic()) { 
						$method->invoke($object, $value);
					}
				}
			}
		
			$result[] = $object;
		}
		
		return $result;
	}
}

?>
 