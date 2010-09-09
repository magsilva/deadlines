<?php

require_once('controller/Event_type.dao.php');
require_once('DAO_Test.class.php');


class Event_type_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Event_type_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$event_type = self::$dao->read(1);
		$this->assertEquals($event_type->get_name(), 'Workshop');
		$this->assertEquals($event_type->get_description(), '');
	}
	
	public function testCreate()
	{
		$data['name'] = 'Meeting';
		$data['description'] = '';
		$event_type_id = self::$dao->create($data);
		$this->assertEquals($event_type_id, 6);
	}

	public function testUpdate()
	{
		$event_type = self::$dao->read(2);
		$this->assertEquals($event_type->get_description(), '');
		
		$event_type->set_description('Conference event');
		self::$dao->update($event_type);
		
		$event_type = self::$dao->read(2);
		$this->assertEquals($event_type->get_description(), 'Conference event');
	}

	public function testDelete()
	{
		$event_type = self::$dao->read(3);
		$this->assertEquals($event_type->get_name(), 'Poster session');
		$this->assertEquals($event_type->get_description(), '');
		
		self::$dao->delete($event_type);
		
		$event_type = self::$dao->read(3);
		$this->assertNull($event_type);
	}
}
?>
