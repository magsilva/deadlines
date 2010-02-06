<?php

require_once('controller/PDO_DAO_Loader_Finder.class.php');
require_once('PHPUnit/Framework.php');


class PDO_DAO_Event_type_Test extends PHPUnit_Framework_TestCase
{
	public function testGenerateURLSQLite()
	{
		$database = '/tmp/test.sqlite';
		$dbms = 'sqlite';
		$host = 'localhost';
		$url = $dbms . ':' . $database;
		$this->assertEquals('sqlite:/tmp/test.sqlite', PDO_DAO_Loader_Finder::generate_url($dbms, $host, $database));
	}

	public function testGenerateURLMySQL()
	{
		$database = 'test';
		$dbms = 'mysql';
		$host = 'localhost';
		$url = $dbms . ':' . $database;
		$this->assertEquals('mysql:host=localhost;dbname=test', PDO_DAO_Loader_Finder::generate_url($dbms, $host, $database));
	}
	
	public function testInitialize()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');	
	}
	
	public function testFindOk()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');	
		$finder->find('Publication_type');
		$this->assertTrue(class_exists('Publication_type_PDO_DAO', false));		
	}

	public function testFindErr()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');	
		$finder->find('Publicationa_type');
		$this->assertFalse(class_exists('Publicationa_type_PDO_DAO', false));		
	}
}
?>
