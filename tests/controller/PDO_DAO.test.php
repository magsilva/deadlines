<?php

require_once('controller/BasicFactory.class.php');
require_once('PHPUnit/Framework.php');

class PDO_DAO_Test extends PHPUnit_Framework_TestCase
{
	private $factory;
	
	public function setUp()
	{
		$this->factory = new BasicFactory();
	}
	
	public function testRegisterLoaderFinder()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');
		$result = $this->factory->registerLoaderFinder($finder);
		$this->assertTrue($result);
	}
	
	public function testRegisterType()
	{
		$type = 'Event';
		$result = $this->factory->registerType($type);
		$this->assertTrue($result);
	}
	
	public function testManufactureOk()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');
		$this->factory->registerLoaderFinder($finder);
		$this->factory->registerType('Event');
		$dao = $this->factory->manufacture('Event');
		$this->assertTrue(is_a($dao, 'Event_PDO_DAO'));
	}
	
	public function testManufactureErr()
	{
		$finder = new PDO_DAO_Loader_Finder('sqlite:/tmp/test.sqlite', 'root', '');
		$result = $this->factory->registerLoaderFinder($finder);
		$dao = $this->factory->manufacture('Beer');
		$this->assertNull($dao);
	}
}
?>
