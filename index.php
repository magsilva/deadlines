<?

require_once('function.check.php');

$deadlines_home = dirname(__FILE__);

$db_user = 'deadlines';
$db_password = 'WqSDYQf4mWZYYfU6';
$db_host = 'localhost';
$db_name = 'deadline';

$template_dir = $deadlines_home . '/templates';
$config_dir = $deadlines_home . '/config';
$cache_dir = $deadlines_home . '/cache';

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


class Work_type
{
	private $id;

	private $name;

	private $description;

	public function __construct($id)
	{
		check_number($id, 'Invalid identifier for Work_type');
		$this->id = $id;
	}

	public function set_name($name)
	{
		check_string($name, 'Invalid name for the work type');
		$this->name = $name;
	}

	public function get_name()
	{
		return $this->name;
	}


	public function set_description($description)
	{
		check_string($description, 'Invalid description for the work type');
		$this->description = $description;
	}

	public function get_description()
	{
		return $this->description;
	}
}


abstract class Deadline
{
	private $id;

	private $work_type;

	private $abstract_deadline;

	private $full_deadline;

	private $submission_url;

	private $information_url;

	private $instructions;


	public function __construct($id)
	{
		check_number($id);
		$this->id = $id;
	}

	public function get_id()
	{
		return $this->id;
	}


	public function set_work_type($work_type)
	{
		$this->work_type = $work_type;
	}

}


class DeadlineEvent extends Deadline
{
//	private $
}

class DeadlinePeriodical extends Deadline
{
}

class DeadlineFactory
{
	public function manufacture($data)
	{
		if ($data['conference_id'] != NULL) {
			return new DeadlineEvent();
		}
		
		if ($data['journal_id'] != NULL) {
			return new DeadlinePeriodical();
		}
	}
}

class DeadlineManager
{
	private $dbh;

	public function __construct($db_host, $db_name, $db_user, $db_password)
	{
		try {
			$this->dbh = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_password);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	public function fetch_periodicals_deadlines()
	{
		$sth = $this->dbh->prepare('SELECT * FROM deadlines INNER JOIN periodicals ON deadlines.journal_id = events.id');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}


	public function fetch_events_deadlines()
	{
		$sth = $this->dbh->prepare('SELECT * FROM deadlines INNER JOIN events ON deadlines.conference_id = events.id');
		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_OBJ);
	}
}


interface Factory
{
	public function manufacture($obj_type, $data);
}

class Factory_DAO implements Factory
{
	private $dbh;

	private static $singletons;

        public function __construct($db_host, $db_name, $db_user, $db_password)
        {
                try {
                        $this->dbh = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_password);
                } catch (PDOException $e) {
                        print "Error!: " . $e->getMessage() . "<br/>";
                        die();
                }

		self::$singletons = array();
		self::$singletons['Deadline'] = array();
		self::$singletons['Work_type'] = array();
        }

	public function manufacture($obj_type, $data)
	{
		switch ($obj_type) {
			case 'work_type':
				return $this->manufacture_work_type($data);
				break;
			case 'event_deadline':
				return $this->manufacture_deadline($data);
				break;
			default:
				trigger_error('Unknown object type');
		}
	}

	private function register_singleton($object)
	{
		self::$singletons[getclass($object)][$object->getId()] = $object->getId();	
	}

	private function manufacture_deadline($id)
	{
		if (isset(self::$singletons['Deadline'][$id])) {
			return self::$singletons['Deadline'][$id];
		}

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



require_once('Smarty/Smarty.class.php');

class Controller
{
	private $smarty;

	public function __construct($template_dir, $config_dir, $cache_dir)
	{
		$this->smarty = new Smarty();
		$this->smarty->template_dir = $template_dir;
		$this->smarty->compile_dir = $cache_dir . '/templates_c';
		$this->smarty->cache_dir = $cache_dir . '/cache';
		$this->smarty->config_dir = $config_dir;

		if (! is_dir($this->smarty->compile_dir)) {
			mkdir($this->smarty->compile_dir, 0700, true);
		}
		if (! is_dir($this->smarty->cache_dir)) {
			mkdir($this->smarty->cache_dir, 0700, true);
		}

		$this->smarty->caching = true;
		$this->smarty->cache_lifetime = 1200;
		$this->smarty->cache_modified_check = true;
		$this->smarty->left_delimiter='{';
		$this->smarty->right_delimiter='}';
	}

	public function set($name, $value)
	{
		$this->smarty->assign($name, $value);
	}

	public function forward($template)
	{
		static $cache_info = array();

		$template_file = $template . '.tpl';
		if (! is_file($this->smarty->template_dir . '/' . $template_file)) {
			trigger_error('There is no template file for ' . $template);			
		}	

		$output = '';
		$output .= $this->smarty->fetch('header.tpl');
		$output .= $this->smarty->fetch($template_file);
		$output .= $this->smarty->fetch('footer.tpl');

		echo $output;
	}
}



function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");


$factory = new Factory_DAO($db_host, $db_name, $db_user, $db_password);
$factory->manufacture('event_deadline', 1);



$controller = new Controller($template_dir, $config_dir, $cache_dir);
$manager = new DeadlineManager($db_host, $db_name, $db_user, $db_password);
$deadlines = $manager->fetch_events_deadlines();


$controller->set('app_name', 'Deadlines');
$controller->set('app_action', 'Index');
$controller->set('deadlines', $deadlines);
$controller->forward('deadlines.read');
?>
