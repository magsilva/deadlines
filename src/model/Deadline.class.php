<?

class Deadline
{
	private $id;
	
	private $event_id;
	
	private $periodical_id;

	private $work_type_id;
	
	private $abstract_submission_deadline;
	
	private $abstract_notification_acceptance;

	private $submission_deadline;

	private $extended_submission_deadline;

	private $notification_acceptance;

	private $camera_ready_submission_deadline;

	private $information_url;
	
	private $submission_url;
	
	private $instructions;

	public function __construct($id)
	{
		check_number($id, 'Invalid id for the deadline.');
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}

	
	public function set_event_id($id)
	{
		check_number($id, 'Invalid event');
		$this->event_id = $id;
	}
	
	public function get_event_id()
	{
		return $this->event_id;
	}

	
	public function set_periodical_id($id)
	{
		check_number($id, 'Invalid periodical');
		$this->periodical_id = $id;
	}
	
	public function get_periodical_id()
	{
		return $this->periodical_id;
	}

	
	public function set_work_type_id($id)
	{
		check_number($id, 'Invalid work type');
		$this->work_type_id = $id;
	}
	
	public function get_work_type_id()
	{
		return $this->work_type_id;
	}
	
	
	public function set_abstract_submission_deadline($date)
	{
		check_date($date, 'Invalid date for the abstract submission deadline.');
		$this->abstract_submission_deadline = $date;
	}

	public function get_abstract_submission_deadline()
	{
		return $this->abstract_submission_deadline;
	}
	
	
	public function set_abstract_notification_acceptance($date)
	{
		check_date($date, 'Invalid date for the abstract notification deadline.');
		check_date_difference($this->abstract_submission_deadline, $date, 0, 'The abstract notification date is set to _before_ the abstract submission date! This is probably incorrect.');
		$this->abstract_notification_acceptance = $date;
	}

	public function get_abstract_notification_acceptance()
	{
		return $this->abstract_notification_acceptance;
	}
	
	
	public function set_submission_deadline($date)
	{
		check_date($date, 'Invalid date for the submission deadline.');
		if ($this->abstract_submission_deadline != NULL) {
			check_date_difference($this->abstract_notification_acceptance, $date, 0, 'The submission date is set to _before_ the abstract notification date! This is probably incorrect.');
		}
		$this->submission_deadline = $date;
	}

	public function get_submission_deadline()
	{
		return $this->submission_deadline;
	}


	public function set_extended_submission_deadline($date)
	{
		check_date($date, 'Invalid date for the extended submission deadline.');
		check_date_difference($this->submission_deadline, $date, 0, 'The extended submission date is _before_ the submission date! This is probably incorrect.');
		$this->extended_submission_deadline = $date;
	}

	public function get_extended_submission_deadline()
	{
		return $this->extended_submission_deadline;
	}


	public function set_notification_acceptance($date)
	{
		check_date($date, 'Invalid date for the notification of acceptance.');
		check_date_difference($this->submission_deadline, $date, 0, 'The notification of acceptance date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extended_submission_deadline, $date, 0, 'The notification of acceptance date is _before_ the extended submission date! This is probably incorrect.');
		$this->notification_acceptance = $date;
	}

	public function get_notification_acceptance()
	{
		return $this->notification_acceptance;
	}


	public function set_camera_ready_submission_deadline($date)
	{
		check_date($date, 'Invalid date for the camera ready deadline.');
		check_date_difference($this->submission_deadline, $date, 0, 'The camera ready date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extended_submission_deadline, $date, 0, 'The camera ready date is _before_ the extended submission date! This is probably incorrect.');
		check_date_difference($this->notification_acceptance, $date, 0, 'The camera ready date is _before_ the notification of acceptance date! This is probably incorrect.');
		$this->camera_ready_submission_deadline = $date;
	}

	public function get_camera_ready_submission_deadline()
	{
		return $this->camera_ready_submission_deadline;
	}


	public function set_information_url($url)
	{
		check_url($url, 'Invalid URL for further information about the deadline');
		$this->information_url = $url;
	}
	
	public function get_information_url()
	{
		return $this->information_url;
	}

	

	public function set_submission_url($url)
	{
		check_url($url, 'Invalid URL for submission of work for the deadline');
		$this->submission_url = $url;
	}

	public function get_submission_url()
	{
		return $this->submission_url;
	}
	
	
	public function set_instructions($instructions)
	{
		check_string($instructions, 'Invalid text for instructions regarding the deadline');
		$this->instructions = $instructions;
	}
	
	public function get_instructions()
	{
		return $this->instructions;
	}
}

?>
