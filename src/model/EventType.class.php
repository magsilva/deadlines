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


class EventType
{
	private $id;

	private $name;

	private $description;

	public function __construct($id)
	{
		check_number($id, 'Invalid identifier for event type');
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function setName($name)
	{
		check_string($name, 'Invalid name for the event type');
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}


	public function setDescription($description)
	{
		check_string($description, 'Invalid description for the event type');
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}
}

?>
