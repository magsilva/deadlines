<?php

require_once('controller/DAO.interface.php');

class PDO_Database extends PDO
{
	public function __construct($db_url, $db_user, $db_password)
	{
		if (strpos($db_url, 'sqlite') == 0) {
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
		} else {
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_AUTOCOMMIT => false,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
		}

		parent::__construct($db_url, $db_user, $db_password, $options);
	}
}

?>
 