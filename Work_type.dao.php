<?

require_once('Database_DAO.class.php');
require_once('Work_type.class.php');

class Work_type_DAO extends Database_DAO
{
        public function __construct($db_driver, $db_host, $db_name, $db_user, $db_password)
	{
		parent::__construct($db_driver, $db_host, $db_name, $db_user, $db_password);
	}

	public function create($data)
	{
		$this->beginTransaction();

		$sth = $this->prepare('INSERT INTO work_types(name, description) VALUES (:name, :description)');
		$sth->bindParam(':name', $data['name']);
		$sth->bindParam(':description', $data['description']);
		$sth->execute();
		$this->commit();
	}

	public function read($id)
	{
		$this->beginTransaction();
		$sth = $this->prepare('SELECT * FROM work_types WHERE id=:id');
		$sth->bindParam(':id', $id);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		$work_type = new Work_type($id);
		$work_type->set_name($result['name']);
		$work_type->set_description($result['description']);

		$this->commit();
		return $work_type;
	}

	public function update($object)
	{
		$this->beginTransactioin();
		$sth = $this->prepare('UPDATE work_types SET name=:name, description=:description WHERE id=:id');
		$sth->bindParam(':id', $object->get_id());
		$sth->bindParam(':name', $object->get_name());
		$sth->bindParam(':description', $object->get_description());
		$sth->execute();

		$this->commit();
	}

	public function delete($object)
	{
		$this->beginTransaction();
		$sth = $this->prepare('DELETE FROM work_types WHERE id=:id');
		$sth->bindParam(':id', $object->get_id());
		$sth->execute();

		$this->commit();
	}
}

?>
