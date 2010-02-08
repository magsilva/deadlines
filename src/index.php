<?php
/*
Copyright (c) 2010 Marco Aurélio Graciotto Silva <magsilva@ironiacorp.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

require_once('config.php');

require_once('controller/ErrorHandler.class.php');
require_once('controller/Controller.class.php');
require_once('controller/DaoFactory.class.php');
require_once('controller/PdoDaoLoaderFinder.class.php');

// $errorHandler = new ErrorHandler();
$daoFactory = new DaoFactory();
$pdoDaoLoaderFinder = new PdoDaoLoaderFinder(PdoDaoLoaderFinder::generate_url($db_dbms, $db_host, $db_name), $db_user, $db_password);
$daoFactory->registerLoaderFinder($pdoDaoLoaderFinder);
$types = $pdoDaoLoaderFinder->findTypes();
foreach ($types as $type) {
	$daoFactory->registerType($type);
} 


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
