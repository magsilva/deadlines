<?php

require_once('DAO.interface.php');

abstract class Database_DAO extends PDO implements DAO
{
        public function __construct($db_url, $db_user, $db_password)
	{
		if (defined('TEST_USING_SQLITE')) {
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

	public static function build_url($db_driver, $db_host, $db_name)
	{
		return $db_driver . ':host=' . $db_host . ';dbname=' . $db_name;
	}
}

?>
