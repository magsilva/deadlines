<?php

require_once('PHPUnit/Framework.php');

class DAO_Test extends PHPUnit_Framework_TestCase
{
	private static $database;
	
	protected static $url;
	
	public static function setUpBeforeClass()
	{
		if (! defined('TEST_USING_SQLITE')) {
			define('TEST_USING_SQLITE', true);
		}

		self::$database = tempnam(sys_get_temp_dir(), 'test');
		self::$url = 'sqlite:' . self::$database;
		echo 'Database will be stored at ' . self::$database . "\n";

		$database = new Database(self::$url, 'root', '');
		$database->beginTransaction();
		$stmts_filename = 'resources/deadline-test.sql';
		echo 'Database will be populated using the statements found at ' . $stmts_filename . "\n";

		$stmts = file_get_contents($stmts_filename, FILE_USE_INCLUDE_PATH);
		$database->exec($stmts);
		$database->commit();
	}

	public static function tearDownAfterClass()
	{
		 unlink(self::$database);
	}
}
?>
