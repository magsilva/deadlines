<?php

require_once('controller/Event.dao.php');
require_once('DAO_Test.class.php');


class Event_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Event_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$event = self::$dao->read(1);
		$this->assertEquals($event->get_publication_id(), 20);
		$this->assertEquals($event->get_type_id(), 1);
	}
	
	public function testCreate()
	{
		$data['publication_id'] = 5;
		$data['type_id'] = 1;
		$event_id = self::$dao->create($data);
		$this->assertEquals($event_id, 22);
	}

	public function testUpdate()
	{
		$event = self::$dao->read(2);
		$this->assertEquals($event->get_publication_id(), 7);
		$this->assertEquals($event->get_type_id(), 1);
		
		$event->set_publication_id(5);
		self::$dao->update($event);
		
		$event = self::$dao->read(2);
		$this->assertEquals($event->get_publication_id(), 5);
	}

	public function testDelete()
	{
		$event = self::$dao->read(1);
		$this->assertEquals($event->get_publication_id(), 20);
		$this->assertEquals($event->get_type_id(), 1);
		
		self::$dao->delete($event);
		
		$event = self::$dao->read(1);
		$this->assertNull($event);
	}
}
?>
