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

class ErrorHandler
{
	public function __construct()
	{
		ini_set('html_errors',false);
		set_error_handler(array($this, 'handleError'));
		set_exception_handler(array($this, 'handleException'));
		register_shutdown_function(array($this, 'handleShutdown'));
	}
	
	public function handleError($errno, $errstr, $errfile, $errline)
	{
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		
		return FALSE;
	}

	public function handleException($exception)
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
		
		return FALSE;
	}
	
	public function handleShutdown()
	{
        $isError = false;
        if ($error = error_get_last()){
            switch($error['type']){
                case E_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    $isError = true;
                    break;
            }
        }

        if ($isError){
            echo "Script execution halted ({$error['message']})";
        } else {
            echo "Script completed";
        }
        
        return FALSE;
    }  
}

?>
