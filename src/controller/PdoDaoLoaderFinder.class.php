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

require_once('controller/LoaderFinder.interface.php');

class PdoDaoLoaderFinder implements LoaderFinder
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
	
	public function findTypes()
	{
		$types = array();
		
		foreach (glob(dirname(__FILE__) . '/../model/*.class.php') as $filename) {
			$type = basename($filename);
			$type = str_replace('.class.php', '', $type);
			$types[] = $type;
		}
		return $types;
	}
	
	public function find($type)
	{
		$class_name = $type . 'PdoDao';
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
require_once('controller/PdoDao.class.php');
require_once('model/@type@.class.php');

class @type@PdoDao extends PdoDao
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
	
	public function findAll()
	{
		return parent::findAll();
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