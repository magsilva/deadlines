<?php

require_once('controller/Publication.dao.php');
require_once('DAO_Test.class.php');


class Publication_Test extends DAO_Test
{
	private static $dao;

	public function setUp()
	{
		self::$dao = new Publication_DAO(self::$url, 'root', '');
	}

	public function testRead()
	{
		$publication = self::$dao->read(3);
		$this->assertEquals($publication->get_name(), 'Ciclo de Palestras sobre Novas Tecnologias na Educação');
		$this->assertEquals($publication->get_type_id(), 1);
		$this->assertNull($publication->get_replaced_by_id());
		$this->assertEquals($publication->get_acronym(), '');
		$this->assertEquals($publication->get_description(), '');
		$this->assertEquals($publication->get_periodicity(), '');
	}
	
	public function testCreate()
	{
		$data['name'] = 'IroniaCorp Carnival';
		$data['type_id'] = 1;
		$data['description'] = '';
		$publication_id = self::$dao->create($data);
		$this->assertEquals($publication_id, 25);
	}

	public function testUpdate()
	{
		$publication = self::$dao->read(4);
		$this->assertEquals($publication->get_description(), '');
		
		$publication->set_description('Best conference on DTV');
		self::$dao->update($publication);
		
		$publication = self::$dao->read(4);
		$this->assertEquals($publication->get_description(), 'Best conference on DTV');
	}

	public function testDelete()
	{
		$publication = self::$dao->read(7);
		$this->assertEquals($publication->get_name(), 'IEEE International Conference on Multimedia & Expo');
		$this->assertEquals($publication->get_description(), '');
		
		self::$dao->delete($publication);
		
		$publication = self::$dao->read(7);
		$this->assertNull($publication);
	}
}
?>
