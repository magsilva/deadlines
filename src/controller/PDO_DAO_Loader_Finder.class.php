<?php

require_once('controller/Loader_Finder.interface.php');


class PDO_DAO_Loader_Finder implements Loader_Finder
{
	private $url;

	private $user;
	
	private $password;
	
	public static function generate_url($dbms, $host, $database)
	{
		if ($dbms == 'sqlite') {
			return $dbms . ':' . $database;
		} else {
			return $dbms . ':host=' . $host . ';dbname=' . $database;
		}
		
	}
	
	public function __construct($url, $user, $password)
	{
		$this->url = $url;
		$this->user = $user;
		$this->password = $password;
	}
	
	public function find($type)
	{
		$class_name = $type . '_PDO_DAO';
		if (! class_exists($class_name, false)) {
				$result = $this->generate_class($type);
			if ($result == FALSE) {
				return NULL;
			}
		} 
		
		$loader = new $class_name($this->url, $this->user, $this->password);
		return $loader;
	}

	private function generate_class($type)
	{
		$result = @include_once('model/' . $type . '.class.php');
		if (! class_exists($type, false)) {
			return FALSE;
		}
			
		$class = <<<EOT
require_once('controller/PDO_DAO.class.php');
require_once('model/@type@.class.php');

class @type@_PDO_DAO extends PDO_DAO
{
	public function __construct(\$url, \$db_user, \$db_password)
	{
		parent::__construct(\$url, \$db_user, \$db_password);
	}

	public function create(\$data)
	{
		return parent::create(\$data);
	}
	
	public function read(\$id)
	{
		return parent::read(\$id);
	}

	public function update(\$object)
	{
		return parent::update(\$object);
	}

	public function delete(\$object)
	{
		return parent::delete(\$object);
	}
}
EOT;
		$class = str_replace('@type@', $type, $class);
		$result = eval($class);
		if ($result === FALSE) {
			trigger_error('Could not generate PDO DAO class for ' . $type, E_USER_ERROR);
			return FALSE;
		}
		
		return TRUE;
	}
	

}
?>