<?php

require_once('Work_type.dao.php');
require_once('DAO.class.php');

class Work_type_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Work_type_DAO(self::$url, 'root', '');
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
