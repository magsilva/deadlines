<?php

require_once('function.check.php');


class Sponsorship
{
	private $publication_id;

	private $sponsors;

	public function __construct($publication_id)
	{
		check_number($id, 'Invalid identifier for publication');
		$this->publication_id = $publication_id;
		$this->sponsors = array();
	}

	public function get_publication_id()
	{
		return $this->publication_id;
	}
	
	public function set_sponsors($sponsors)
	{
		check_array_number($sponsors, 'Invalid sponsors');
		$this->sponsors = $sponsors;
	}
	
	public function add_sponsor($spondor_id)
	{
		check_number($sponsor_id, 'Invalid sponsor id');
		if (! in_array($sponsor_id, $this->sponsors)) {
			$this->sponsors[] = $sponsor;
		}
	}

	public function get_sponsors()
	{
		return $this->sponsors;
	}
}

?>
