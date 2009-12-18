<?php

require_once('Work_type.dao.php');
require_once('PHPUnit/Framework.php');

class Work_type_Test extends PHPUnit_Framework_TestCase
{
	private $dao;

	private $database;

	protected function setUp()
	{
		$this->database = tempnam(sys_get_temp_dir(), 'test');
		$url = 'sqlite:' . $database;
		echo 'Database will be stored at' . $this->database;

		$this->dao = new Work_type_DAO($url, 'root', '');
		$this->dao->beginTransaction();
		$sql_stmts_filename = 'resources/deadline-test.sql';
		$sql_stmts = file($data_filename, FILE_SKIP_EMPTY_LINES);
		foreach ($sql_stmts as $stmt) {
			$this->dao->exec($stmt);
		}
		$this->dao->commit();
        }

	protected function tearDown()
	{
		unlink($this->database);
	}
}
?>
