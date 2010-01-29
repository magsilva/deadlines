<?

require_once('Database_DAO.class.php');
require_once('Periodical.class.php');


class Periodical_DAO extends Database_DAO
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
		return parent::update($object);
	}

	public function delete($object)
	{
		return parent::delete($object);
	}
}

?>
