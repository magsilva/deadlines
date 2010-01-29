<?php

require_once('Periodical_type.dao.php');
require_once('DAO.class.php');


class Periodical_type_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Periodical_type_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$work_type = self::$dao->read(1);
		$this->assertEquals($work_type->get_name(), 'Journal');
		$this->assertEquals($work_type->get_description(), '');
	}
	
	public function testCreate()
	{
		$data['name'] = 'Book';
		$data['description'] = '';
		$periodical_type_id = self::$dao->create($data);
		$this->assertEquals($periodical_type_id, 3);
	}

	public function testUpdate()
	{
		$periodical_type = self::$dao->read(2);
		$this->assertEquals($periodical_type->get_description(), '');
		
		$periodical_type->set_description('Magazine periodical publication');
		self::$dao->update($periodical_type);
		
		$periodical_type = self::$dao->read(2);
		$this->assertEquals($periodical_type->get_description(), 'Magazine periodical publication');
	}

	public function testDelete()
	{
		$periodical_type = self::$dao->read(1);
		$this->assertEquals($periodical_type->get_name(), 'Journal');
		$this->assertEquals($periodical_type->get_description(), '');
		
		self::$dao->delete($periodical_type);
		
		$periodical_type = self::$dao->read(1);
		$this->assertNull($periodical_type);
	}
}
?>
