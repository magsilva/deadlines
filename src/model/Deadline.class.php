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

class Deadline
{
	private $id;
	
	private $eventId;
	
	private $periodicalId;

	private $workTypeId;
	
	private $abstractSubmissionDeadline;
	
	private $abstractNotificationAcceptance;

	private $submissionDeadline;

	private $extendedSubmissionDeadline;

	private $notificationAcceptance;

	private $cameraReadySubmissionDeadline;

	private $informationUrl;
	
	private $submissionUrl;
	
	private $instructions;

	public function __construct($id)
	{
		check_number($id, 'Invalid id for the deadline.');
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	
	public function setEventId($id)
	{
		check_number($id, 'Invalid event');
		$this->eventId = $id;
	}
	
	public function getEventId()
	{
		return $this->eventId;
	}

	
	public function setPeriodicalId($id)
	{
		check_number($id, 'Invalid periodical');
		$this->periodicalId = $id;
	}
	
	public function getPeriodicalId()
	{
		return $this->periodicalId;
	}

	
	public function setWorkTypeId($id)
	{
		check_number($id, 'Invalid work type');
		$this->workTypeId = $id;
	}
	
	public function getWorkTypeId()
	{
		return $this->workTypeId;
	}
	
	
	public function setAbstractSubmissionDeadline($date)
	{
		check_date($date, 'Invalid date for the abstract submission deadline.');
		$this->abstractSubmissionDeadline = $date;
	}

	public function getAbstractSubmissionDeadline()
	{
		return $this->abstractSubmissionDeadline;
	}
	
	
	public function setAbstractNotificationAcceptance($date)
	{
		check_date($date, 'Invalid date for the abstract notification deadline.');
		check_date_difference($this->abstractSubmissionDeadline, $date, 0, 'The abstract notification date is set to _before_ the abstract submission date! This is probably incorrect.');
		$this->abstractNotificationAcceptance = $date;
	}

	public function getAbstractNotificationAcceptance()
	{
		return $this->abstractNotificationAcceptance;
	}
	
	
	public function setSubmissionDeadline($date)
	{
		check_date($date, 'Invalid date for the submission deadline.');
		if ($this->abstractSubmissionDeadline != NULL) {
			check_date_difference($this->abstractNotificationAcceptance, $date, 0, 'The submission date is set to _before_ the abstract notification date! This is probably incorrect.');
		}
		$this->submissionDeadline = $date;
	}

	public function getSubmissionDeadline()
	{
		return $this->submissionDeadline;
	}


	public function setExtendedSubmissionDeadline($date)
	{
		check_date($date, 'Invalid date for the extended submission deadline.');
		check_date_difference($this->submissionDeadline, $date, 0, 'The extended submission date is _before_ the submission date! This is probably incorrect.');
		$this->extendedSubmissionDeadline = $date;
	}

	public function getExtendedSubmissionDeadline()
	{
		return $this->extendedSubmissionDeadline;
	}


	public function setNotificationAcceptance($date)
	{
		check_date($date, 'Invalid date for the notification of acceptance.');
		check_date_difference($this->submissionDeadline, $date, 0, 'The notification of acceptance date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extendedSubmissionDeadline, $date, 0, 'The notification of acceptance date is _before_ the extended submission date! This is probably incorrect.');
		$this->notificationAcceptance = $date;
	}

	public function getNotificationAcceptance()
	{
		return $this->notificationAcceptance;
	}


	public function setCameraReadySubmissionDeadline($date)
	{
		check_date($date, 'Invalid date for the camera ready deadline.');
		check_date_difference($this->submissionDeadline, $date, 0, 'The camera ready date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extendedSubmissionDeadline, $date, 0, 'The camera ready date is _before_ the extended submission date! This is probably incorrect.');
		check_date_difference($this->notificationAcceptance, $date, 0, 'The camera ready date is _before_ the notification of acceptance date! This is probably incorrect.');
		$this->cameraReadySubmissionDeadline = $date;
	}

	public function getCameraReadySubmissionDeadline()
	{
		return $this->cameraReadySubmissionDeadline;
	}


	public function setInformationUrl($url)
	{
		check_url($url, 'Invalid URL for further information about the deadline');
		$this->informationUrl = $url;
	}
	
	public function getInformationUrl()
	{
		return $this->informationUrl;
	}

	

	public function setSubmissionUrl($url)
	{
		check_url($url, 'Invalid URL for submission of work for the deadline');
		$this->submissionUrl = $url;
	}

	public function getSubmissionUrl()
	{
		return $this->submissionUrl;
	}
	
	
	public function setInstructions($instructions)
	{
		check_string($instructions, 'Invalid text for instructions regarding the deadline');
		$this->instructions = $instructions;
	}
	
	public function getInstructions()
	{
		return $this->instructions;
	}
}

?>
