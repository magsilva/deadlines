<?

require_once('Work_type.class.php');

class Work_type_DAO extends Database_DAO
{
        public function __construct($db_driver, $db_host, $db_name, $db_user, $db_password)
	{
		parent::__construct($db_driver, $db_host, $db_name, $db_user, $db_password);
	}

	private function manufacture_deadline($id)
	{
	
		$sth = $this->dbh->prepare('SELECT * FROM deadlines WHERE id = :id');
		$sth->bindParam(':id', $id);
		$sth->execute();
		$result1 = $sth->fetch(PDO::FETCH_ASSOC);


		if ($result['conference_id'] != NULL) {
			$deadline_type = 'event';
		} else if ($result['journal_id'] != NULL) {
			$deadline_type = 'periodical';
		} else {
			trigger_error('Deadline has not been associated to any periodical or event');
		}


		switch ($deadline_type) {
			case 'event':
				$sth = $this->dbh->prepare('SELECT * FROM deadlines INNER JOIN events ON deadlines.conference_id = events.id WHERE deadlines.id = :id');
				$deadline = new DeadlineEvent($id);
				break;
			case 'periodical':
				$sth = $this->dbh->prepare('SELECT * FROM deadlines INNER JOIN periodicals ON deadlines.journal_id = periodicals.id WHERE deadlines.id = :id');
				$deadline = new DeadlinePeriodical($id);
				break;
			default:
				assert(false);
		}	

		$sth->bindParam(':id', $id);
		$sth->execute();
		$result2 = $sth->fetch(PDO::FETCH_ASSOC);

		$deadline->set
	}

	private function manufacture_work_type($id)
	{
		if (isset(self::$singletons['Work_type'][$id])) {
			return self::$singletons['Work_type'][$id];
		}

		$sth = $this->dbh->prepare('SELECT * FROM work_types WHERE id=:id');
		$sth->bindParam(':id', $id);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);

		$work_type = new Work_type($id);
		$work_type->set_name($result['name']);
		$work_type->set_description($result['description']);

		$this->singletons['Work_type'][$id] = $work_type;

		return $work_type;
	}
}

?>
