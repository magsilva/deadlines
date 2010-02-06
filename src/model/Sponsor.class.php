<?php

require_once('function.check.php');


class Sponsor
{
	private $id;

	private $name;

	private $description;

	public function __construct($id)
	{
		check_number($id, 'Invalid identifier for sponsor');
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}
	
	public function set_name($name)
	{
		check_string($name, 'Invalid name for the sponsor');
		$this->name = $name;
	}

	public function get_name()
	{
		return $this->name;
	}


	public function set_description($description)
	{
		check_string($description, 'Invalid description for the sponsor');
		$this->description = $description;
	}

	public function get_description()
	{
		return $this->description;
	}
}

?>
