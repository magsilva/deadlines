<?

require_once('config.php');

require_once('ErrorHandler.class.php');
require_once('Controller.class.php');
require_once('SingletonFactory.class.php');


$factory = new SingletonFactory($db_host, $db_name, $db_user, $db_password);
$controller = new Controller($template_dir, $config_dir, $cache_dir);


if (! isset($_REQUEST['object']) || ! isset($_REQUEST['operation'])) {
	$_REQUEST['object'] = $default_object;
	$_REQUEST['operation'] = $default_operation;
}

$controller->process($_REQUEST['object'], $_REQUEST['operation'], $_REQUEST);


/*
$controller->set('app_name', 'Deadlines');
$controller->set('app_action', 'Main');
$controller->forward('main');
*/
?>
