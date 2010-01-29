<?php

require_once('Database.class.php');
require_once('DAO.interface.php');

abstract class Database_DAO extends Database implements DAO
{
	public function __construct($db_url, $db_user, $db_password)
	{
		parent::__construct($db_url, $db_user, $db_password);
	}

	protected function get_type()
	{
		$class = get_class($this);
		$type = str_replace('_DAO', '', $class);
		return $type;		
	}

	protected function get_table_name()
	{
		$type = $this->get_type();
		$table = strtolower($type) . 's';
		return $table;		
	}

	public function create($data)
	{
		$table = $this->get_table_name();
		
		$stmt = 'INSERT INTO ' . $table . '(';
		foreach ($data as $key => $value) {
			$stmt .= $key . ', ';
		}
		$stmt = substr($stmt, 0, strlen($stmt) - 2);
		
		$stmt .= ') VALUES (';
		foreach ($data as $key => $value) {
			$stmt .= ':' . $key . ', ';
		}
		$stmt = substr($stmt, 0, strlen($stmt) - 2);
		$stmt .= ')';
		
		$this->beginTransaction();
		$sth = $this->prepare($stmt);
		
		foreach($data as $key => $value) {
			$sth->bindValue(':' . $key, $value);
		}
		$sth->execute();
		$this->commit();
		
		return $this->lastInsertId();
	}
		
	
	public function read($id)
	{
		$type = $this->get_type();
		$table = $this->get_table_name();
		
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
		$object = $class->newInstance($id);
		foreach ($result as $key => $value) {
			$method_name = 'set_' . $key;
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
		$type = $this->get_type();
		$table = $this->get_table_name();
		
		$this->beginTransaction();
		$stmt = 'UPDATE ' . $table . ' SET ';
	
		$class = new ReflectionClass($type);
		$properties = $class->getProperties();
		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get_' . $property->getName()) && $class->hasMethod('set_' . $property->getName())) {
				$stmt .= $property->getName() . '=:' . $property->getName() . ', '; 	
			}
		}
		if (strpos($stmt, ', ', strlen($stmt) - 2)) {
			$stmt = substr($stmt, 0, strlen($stmt) - 2);
		}
		
		$stmt .= ' WHERE ';
		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get_' . $property->getName()) && ! $class->hasMethod('set_' . $property->getName())) {
				$stmt .= $property->getName() . '=:' . $property->getName() . ', '; 	
			}
		}
		if (strpos($stmt, ', ', strlen($stmt) - 2)) {
			$stmt = substr($stmt, 0, strlen($stmt) - 2);
		}
		
		$sth = $this->prepare($stmt);
		
		foreach ($properties as $property) {
			if ($property->isPrivate() && $class->hasMethod('get_' . $property->getName())) {
				$method = $class->getMethod('get_' . $property->getName());
				$value = $method->invoke($object);
				$sth->bindValue(':' . $property->getName(), $value);
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
		$table = $this->get_table_name();
		
		$this->beginTransaction();
		$sth = $this->prepare('DELETE FROM ' . $table . ' WHERE id=:id');
		$sth->bindValue(':id', $object->get_id());
		$sth->execute();
		$this->commit();
	}
}

?>
 