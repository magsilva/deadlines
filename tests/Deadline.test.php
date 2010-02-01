<?php

require_once('Deadline.dao.php');
require_once('DAO.class.php');


class Deadline_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Deadline_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$deadline = self::$dao->read(1);
		$this->assertEquals($deadline->get_event_id(), 1);
		$this->assertEquals($deadline->get_periodical_id(), NULL);
		$this->assertEquals($deadline->get_work_type_id(), 3);
		$this->assertEquals($deadline->get_abstract_submission_deadline(), NULL);
		$this->assertEquals($deadline->get_abstract_notification_acceptance(), NULL);
		$this->assertEquals($deadline->get_submission_deadline(), '2009-12-15');
		$this->assertEquals($deadline->get_extended_submission_deadline(), NULL);
		$this->assertEquals($deadline->get_notification_acceptance(), NULL);
		$this->assertEquals($deadline->get_submission_url(), 'mailto:kaner@cs.fit.edu');
		$this->assertEquals($deadline->get_information_url(), NULL);
		$this->assertTrue(strpos($deadline->get_instructions(), '9th WORKSHOP ON TEACHING SOFTWARE TESTING') == 0);
	}
	
	public function testCreate()
	{
		$data['event_id'] = 1;
		$deadline_id = self::$dao->create($data);
		$this->assertEquals($deadline_id, 27);
	}

	public function testUpdate()
	{
		$deadline = self::$dao->read(1);
		$this->assertEquals($deadline->get_work_type_id(), 3);
		
		$deadline->set_work_type_id(5);
		self::$dao->update($deadline);
		
		$deadline = self::$dao->read(1);
		$this->assertEquals($deadline->get_work_type_id(), 5);
	}

	public function testDelete()
	{
		$deadline = self::$dao->read(5);
		$this->assertEquals($deadline->get_event_id(), 4);
		
		self::$dao->delete($deadline);
		
		$deadline = self::$dao->read(5);
		$this->assertNull($deadline);
	}
}
?>
