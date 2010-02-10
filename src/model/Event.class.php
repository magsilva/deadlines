<?php
/*
Copyright (c) 2010 Marco Aurélio Graciotto Silva <magsilva@ironiacorp.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

require_once('function.check.php');

class Event
{
	private $id;
	
	private $typeId;
	
	private $publicationId;

	private $coLocatedWithId;
	
	private $startDate;
	
	private $endDate;
	
	private $location;
	
	private $acceptanceRate;
	
	public function __construct($id)
	{
		check_number($id, 'Invalid identifier for event');
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}

	public function setPublicationId($publicationId)
	{
		check_number($publicationId, 'Invalid publication');
		$this->publicationId = $publicationId;
	}
	
	public function getPublicationId()
	{
		return $this->publicationId;
	}
	
	
	public function setTypeId($typeId)
	{
		check_number($typeId, 'Invalid event type');
		$this->typeId = $typeId;
	}
	
	public function getTypeId()
	{
		return $this->typeId;
	}


	public function setCoLocatedWithId($coLocatedWithId)
	{
		check_number($coLocatedWithId, 'Invalid event identifier');
		$this->coLocatedWithId = $coLocatedWithId;
	}
	
	public function getCoLocatedWithId()
	{
		return $this->coLocatedWithId;
	}
	
	
	public function setStartDate($startDate)
	{
		check_date($startDate, 'Invalid start date');
		$this->startDate = $startDate;
	}
	
	public function getStartDate()
	{
		return $this->start_date;
	}
	

	public function setEndDate($endDate)
	{
		check_date($endDate, 'Invalid end date');
		$this->endDate = $endDate;
	}
	
	public function get_endDate()
	{
		return $this->endDate;
	}
	
	
	public function setLocation($location)
	{
		check_string($location, 'Invalid location');
		$this->location = $location;
	}
	
	public function getLocation()
	{
		return $this->location;
	}
	
	
	public function setAcceptanceRate($acceptanceRate)
	{
		check_decimal($acceptanceRate, 'Invalid acceptance_rate');
		$this->acceptanceRate = $acceptanceRate;
	}
	
	public function getAcceptanceRate()
	{
		return $this->acceptanceRate;
	}	
}

?>
