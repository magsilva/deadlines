<?php

$deadlines_home = dirname(__FILE__);

$db_dbms = 'mysql';
$db_user = 'deadlines';
$db_password = 'WqSDYQf4mWZYYfU6';
$db_host = 'localhost';
$db_name = 'deadline';

$template_dir = $deadlines_home . '/templates';
$config_dir = $deadlines_home . '/config';
$cache_dir = $deadlines_home . '/cache';

$default_object = 'deadlines';
$default_operation = 'view';

set_magic_quotes_runtime(0);

if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
	foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
	foreach($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);
	foreach($_REQUEST as $k => $v) $_REQUEST[$k] = stripslashes($v);
}

?>