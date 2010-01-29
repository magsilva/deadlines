<?php

require_once('Publication_type.dao.php');
require_once('DAO.class.php');


class Publication_type_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Publication_type_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$work_type = self::$dao->read(1);
		$this->assertEquals($work_type->get_name(), 'Event');
		$this->assertEquals($work_type->get_description(), '');
	}
	
	public function testCreate()
	{
		$data['name'] = 'Committee board';
		$data['description'] = '';
		$publication_type_id = self::$dao->create($data);
		$this->assertEquals($publication_type_id, 3);
	}

	public function testUpdate()
	{
		$publication_type = self::$dao->read(2);
		$this->assertEquals($publication_type->get_description(), '');
		
		$publication_type->set_description('Periodical publication');
		self::$dao->update($publication_type);
		
		$publication_type = self::$dao->read(2);
		$this->assertEquals($publication_type->get_description(), 'Periodical publication');
	}

	public function testDelete()
	{
		$publication_type = self::$dao->read(1);
		$this->assertEquals($publication_type->get_name(), 'Event');
		$this->assertEquals($publication_type->get_description(), '');
		
		self::$dao->delete($publication_type);
		
		$publication_type = self::$dao->read(1);
		$this->assertNull($publication_type);
	}
}
?>
