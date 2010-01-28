<?php

require_once('Work_type.dao.php');
require_once('PHPUnit/Framework.php');

class Work_type_Test extends PHPUnit_Framework_TestCase
{
	private static $dao;

	private static $database;

	public static function setUpBeforeClass()
	{
		define('TEST_USING_SQLITE', true);

		self::$database = tempnam(sys_get_temp_dir(), 'test');
		$url = 'sqlite:' . self::$database;
		echo 'Database will be stored at ' . self::$database . "\n";

		self::$dao = new Work_type_DAO($url, 'root', '');
		self::$dao->beginTransaction();
		$stmts_filename = 'resources/deadline-test.sql';
		echo 'Database will be populated using the statements found at ' . $stmts_filename . "\n";

		$stmts = file_get_contents($stmts_filename, FILE_USE_INCLUDE_PATH);
		self::$dao->exec($stmts);
		self::$dao->commit();
	}

	public static function tearDownAfterClass()
	{
		 unlink(self::$database);
	}

	public function testRead()
	{
		$work_type = self::$dao->read(3);
		$this->assertEquals($work_type->get_name(), 'Proposal');
		$this->assertEquals($work_type->get_description(), '');
	}
	
	public function testCreate()
	{
		$data['name'] = 'Thesis';
		$data['description'] = '';
		$work_type_id = self::$dao->create($data);
		$this->assertEquals($work_type_id, 10);
	}

	public function testUpdate()
	{
		$work_type = self::$dao->read(3);
		$this->assertEquals($work_type->get_description(), '');
		
		$work_type->set_description('Proposal for a new research');
		self::$dao->update($work_type);
		
		$work_type = self::$dao->read(3);
		$this->assertEquals($work_type->get_description(), 'Proposal for a new research');
	}

	public function testDelete()
	{
		$work_type = self::$dao->read(4);
		$this->assertEquals($work_type->get_name(), 'Presentation');
		$this->assertEquals($work_type->get_description(), '');
		
		self::$dao->delete($work_type);
		
		$work_type = self::$dao->read(4);
		$this->assertNull($work_type);
	}
}
?>
