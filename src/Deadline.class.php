<?


class DeadlineDate
{
	private $name;

	private $submission;

	private $extended_submission;

	private $notification;

	private $camera_ready;


	public function __construct($name)
	{
		$this->set_name($name);
	}

	public function set_name($name)
	{
		check_string($name, 'Invalid name for the deadline.');
		$this->name = name;
	} 

	public function get_name()
	{
		return $this->name;
	}


	public function set_submission($date)
	{
		check_date($date, 'Invalid date for the submission deadline.');
		$this->submission = $date;
	}

	public function get_submission()
	{
		return $this->submission;
	}


	public function set_extended_submission($date)
	{
		check_date($date, 'Invalid date for the extended submission deadline.');
		check_date_difference($this->submission, $date, 0, 'The extended submission date is _before_ the submission date! This is probably incorrect.');
		$this->extended_submission = $date;
	}

	public function get_extended_submission()
	{
		return $this->extended_submission;
	}


	public function set_notification($date)
	{
		check_date($date, 'Invalid date for the notification of acceptance.');
		check_date_difference($this->submission, $date, 0, 'The notification of acceptance date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extended_submission, $date, 0, 'The notification of acceptance date is _before_ the extended submission date! This is probably incorrect.');
		$this->notification = $date;
	}

	public function get_notification()
	{
		return $this->notification();
	}


	public function set_camera_ready($date)
	{
		check_date($date, 'Invalid date for the camera ready deadline.');
		check_date_difference($this->submission, $date, 0, 'The camera ready date is _before_ the submission date! This is probably incorrect.');
		check_date_difference($this->extended_submission, $date, 0, 'The camera ready date is _before_ the extended submission date! This is probably incorrect.');
		check_date_difference($this->notification, $date, 0, 'The camera ready date is _before_ the notification of acceptance date! This is probably incorrect.');
		$this->notification = $date;
	}

	public function get_camera_ready()
	{
		return $this->camera_ready();
	}


}

abstract class Deadline
{
}


class DeadlineEvent extends Deadline
{
//	private $
}

class DeadlinePeriodical extends Deadline
{
}


?>
