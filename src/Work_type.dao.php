<?

require_once('Database_DAO.class.php');
require_once('Work_type.class.php');

class Work_type_DAO extends Database_DAO
{
	public function __construct($url, $db_user, $db_password)
	{
		parent::__construct($url, $db_user, $db_password);
	}

	public function create($data)
	{
		return parent::create($data);
	}

	
	public function read($id)
	{
		return parent::read($id);
	}

	public function update($object)
	{
		$this->beginTransaction();
		$sth = $this->prepare('UPDATE work_types SET name=:name, description=:description WHERE id=:id');
		$name = $object->get_name();
		$description = $object->get_description();
		$id = $object->get_id();
		
		$sth->bindParam(':name', $name);
		$sth->bindParam(':description', $description);
		$sth->bindParam(':id', $id);
		
		$sth->execute();
		$this->commit();
	}

	public function delete($object)
	{
		$this->beginTransaction();
		$sth = $this->prepare('DELETE FROM work_types WHERE id=:id');
		$id = $object->get_id();
		$sth->bindParam(':id', $id);
		$sth->execute();

		$this->commit();
	}
}

?>
