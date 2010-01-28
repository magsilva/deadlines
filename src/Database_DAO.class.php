<?php

require_once('DAO.interface.php');

abstract class Database_DAO extends PDO implements DAO
{
	public function __construct($db_url, $db_user, $db_password)
	{
		if (defined('TEST_USING_SQLITE')) {
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
		} else {
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_AUTOCOMMIT => false,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
		}

		parent::__construct($db_url, $db_user, $db_password, $options);
	}

	public static function build_url($db_driver, $db_host, $db_name)
	{
		return $db_driver . ':host=' . $db_host . ';dbname=' . $db_name;
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
			$sth->bindParam(':' . $key, $value);
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
		$sth->bindParam(':id', $id);
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
		$this->beginTransaction();
		$sth = $this->prepare('UPDATE work_types SET name=:name, description=:description WHERE id=:id');
		$name = $object->get_name();
		$description = $object->get_description();
		$id = $object->get_id();
		
		$sth->bindParam(':name', $name);
		$sth->bindParam(':description', $description);
		$sth->bindParam(':id', $id);
		
		$sth->execute();
		$this->commit();
	}
	
	
}

?>
