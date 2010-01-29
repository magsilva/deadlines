<?

require_once('function.check.php');

class Publication
{
	private $id;
	
	private $type_id;

	private $replaced_by_id;
	
	private $name;
	
	private $acronym;

	private $description;
	
	private $periodicity;

	public function __construct($id, $type_id)
	{
		check_number($id, 'Invalid identifier for publication');
		check_number($type_id, 'Invalid publication type');
		$this->id = $id;
		$this->type_id = $type_id;
	}

	
	public function get_id()
	{
		return $this->id;
	}

	public function get_type_id()
	{
		return $this->type_id;
	}

	public function set_replaced_by_id($replaced_by_id)
	{
		check_number($replaced_by_id, 'Invalid publication type');
		$this->replaced_by_id = $replaced_by_id;
	}
	
	public function get_replaced_by_id()
	{
		return $this->replaced_by_id;
	}
	
	
	public function set_name($name)
	{
		check_string($name, 'Invalid name for the publication');
		$this->name = $name;
	}

	public function get_name()
	{
		return $this->name;
	}

	
	public function set_acronym($acronym)
	{
		check_string($acronym, 'Invalid acronym for the publication');
		$this->acronym = $acronym;
	}

	public function get_acronym()
	{
		return $this->acronym;
	}

	public function set_description($description)
	{
		check_string($description, 'Invalid description for the publication');
		$this->description = $description;
	}

	public function get_description()
	{
		return $this->description;
	}
	
	
	public function set_periodicity($periodicity)
	{
		check_string($periodicity, 'Invalid periodicity for the publication');
		$this->periodicity = $periodicity;
	}

	public function get_periodicity()
	{
		return $this->periodicity;
	}
}

?>
