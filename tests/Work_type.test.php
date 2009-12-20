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
		echo 'Database will be stored at ' . self::$database;

		self::$dao = new Work_type_DAO($url, 'root', '');
		self::$dao->beginTransaction();
		$sql_stmts_filename = dirname(__FILE__) . '/../resources/deadline-test.sql';
		echo 'Database will be populated using the statements found at ' . $sql_stmts_filename;

		$sql_stmts = file($sql_stmts_filename, FILE_SKIP_EMPTY_LINES);
		foreach ($sql_stmts as $stmt) {
			self::$dao->exec($stmt);
		}
		self::$dao->commit();
        }

	public static function tearDownAfterClass()
	{
		unlink(self::$database);
	}

	public function testOne()
	{
		print __METHOD__ . "\n";
		$this->assertTrue(TRUE);
	}
}
?>
