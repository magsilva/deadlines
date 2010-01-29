<?

require_once('function.check.php');

class Event
{
	private $id;
	
	private $type_id;
	
	private $publication_id;

	private $co_located_with_id;
	
	private $start_date;
	
	private $end_date;
	
	private $location;
	
	private $acceptance_rate;
	
	public function __construct($id, $publication_id, $type_id)
	{
		check_number($id, 'Invalid identifier for event');
		check_number($publication_id, 'Invalid publication');
		check_number($type_id, 'Invalid event type');
		$this->id = $id;
		$this->publication_id = $publication_id;
		$this->type_id = $type_id;
	}
	
	public function get_id()
	{
		return $this->id;
	}

	public function set_publication_id($publication_id)
	{
		check_number($publication_id, 'Invalid publication');
		$this->publication_id = $publication_id;
	}
	
	public function get_publication_id()
	{
		return $this->publication_id;
	}
	
	
	public function set_type_id($type_id)
	{
		check_number($type_id, 'Invalid event type');
		$this->type_id = $type_id;
	}
	
	public function get_type_id()
	{
		return $this->type_id;
	}


	public function set_co_located_with_id($co_located_with_id)
	{
		check_number($co_located_with_id, 'Invalid event identifier');
		$this->co_located_with_id = $co_located_with_id;
	}
	
	public function get_co_located_with_id()
	{
		return $this->co_located_with_id;
	}
	
	
	public function set_start_date($start_date)
	{
		check_date($start_date, 'Invalid start date');
		$this->start_date = $start_date;
	}
	
	public function get_start_date()
	{
		return $this->start_date;
	}
	

	public function set_end_date($end_date)
	{
		check_date($end_date, 'Invalid end date');
		$this->end_date = $end_date;
	}
	
	public function get_end_date()
	{
		return $this->end_date;
	}
	
	
	public function set_location($location)
	{
		check_string($location, 'Invalid location');
		$this->location = $location;
	}
	
	public function get_location()
	{
		return $this->location;
	}
	
	
	public function set_acceptance_rate($acceptance_rate)
	{
		check_decimal($acceptance_rate, 'Invalid acceptance_rate');
		$this->acceptance_rate = $acceptance_rate;
	}
	
	public function get_acceptance_rate()
	{
		return $this->acceptance_rate;
	}	
}

?>
