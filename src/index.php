<?

require_once('Controller.class.php');
require_once('SingletonFactory.class.php');


$deadlines_home = dirname(__FILE__);

$db_user = 'deadlines';
$db_password = 'WqSDYQf4mWZYYfU6';
$db_host = 'localhost';
$db_name = 'deadline';

$template_dir = $deadlines_home . '/templates';
$config_dir = $deadlines_home . '/config';
$cache_dir = $deadlines_home . '/cache';



$factory = new SingletonFactory($db_host, $db_name, $db_user, $db_password);

$controller = new Controller($template_dir, $config_dir, $cache_dir);

/*
$controller->set('app_name', 'Deadlines');
$controller->set('app_action', 'Main');
$controller->forward('main');
*/
?>
