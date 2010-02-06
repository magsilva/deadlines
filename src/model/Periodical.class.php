<?

require_once('function.check.php');

class Periodical
{
	private $id;
	
	private $publication_id;

	private $type_id;
	
	public function __construct($id, $publication_id, $type_id)
	{
		check_number($id, 'Invalid identifier for publication');
		check_number($publication_id, 'Invalid publication');
		check_number($type_id, 'Invalid periodical type');
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
		check_number($type_id, 'Invalid periodical type');
		$this->type_id = $type_id;
	}
	
	public function get_type_id()
	{
		return $this->type_id;
	}
}

?>
