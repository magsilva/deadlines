<?php

require_once('Periodical.dao.php');
require_once('DAO.class.php');


class Periodical_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Periodical_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$periodical = self::$dao->read(1);
		$this->assertEquals($periodical->get_publication_id(), 9);
		$this->assertEquals($periodical->get_type_id(), 1);
	}
	
	public function testCreate()
	{
		$data['publication_id'] = 5;
		$data['type_id'] = 1;
		$periodical_id = self::$dao->create($data);
		$this->assertEquals($periodical_id, 2);
	}

	public function testUpdate()
	{
		$periodical = self::$dao->read(1);
		$this->assertEquals($periodical->get_publication_id(), 9);
		$this->assertEquals($periodical->get_type_id(), 1);
		
		$periodical->set_publication_id(7);
		self::$dao->update($periodical);
		
		$periodical = self::$dao->read(1);
		$this->assertEquals($periodical->get_publication_id(), 7);
	}

	public function testDelete()
	{
		$periodical = self::$dao->read(1);
		$this->assertEquals($periodical->get_publication_id(), 7);
		$this->assertEquals($periodical->get_type_id(), 1);
		
		self::$dao->delete($periodical);
		
		$periodical = self::$dao->read(1);
		$this->assertNull($periodical);
	}
}
?>
