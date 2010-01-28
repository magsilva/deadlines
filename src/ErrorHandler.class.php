<?php

function error_handler($errno, $errstr, $errfile, $errline)
{
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	return FALSE;
}

function exception_handler($exception)
{
	switch ($exception->getSeverity()) {
		case E_USER_ERROR:
			echo "Fatal: ($errfile, $errline) $errstr - ";
			exit(1);
			break;

		case E_USER_WARNING:
			echo "Warning: ($errfile, $errline) $errstr\n";
			break;

		case E_USER_NOTICE:
			echo "Notice: ($errfile, $errline) $errstr\n";
			break;

		default:
			echo "Unknown error type: [$errno] ($errfile, $errline) $errstr\n";
			break;
	}
}



set_error_handler('error_handler');

set_exception_handler('exception_handler');

?>
