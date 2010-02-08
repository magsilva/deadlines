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


require_once('controller/Factory.interface.php');

class DaoFactory implements Factory
{
	private $loaders;
	
	private $loaderFinders;
	
	public function __construct()
	{
		$this->loaders = array();
		$this->loaderFinders = array();
	}

	private function checkLoaderFinder($finder)
	{
		if ($finder == NULL) {
			trigger_error('Invalid loader', E_USER_ERROR);
		}
		
		if (! is_object($finder)) {
			trigger_error('Invalid loader', E_USER_ERROR);
		}
		
		$interfaces = class_implements($finder, false);
		if ($interfaces === FALSE || ! in_array('LoaderFinder', $interfaces)) {
			trigger_error('Loader does not implement the required interface', E_USER_WARNING);
			return FALSE;
		}

		return true;
	}
	
	
	private function checkLoader($loader)
	{
		if ($loader == NULL) {
			trigger_error('Invalid loader', E_USER_ERROR);
		}
		
		if (! is_object($loader)) {
			trigger_error('Invalid loader', E_USER_ERROR);
		}
		
		$interfaces = class_implements($loader, false);
		if ($interfaces === FALSE || ! in_array('DAO', $interfaces)) {
			trigger_error('Loader does not implement any interface (nor the required CRUD interface)', E_USER_WARNING);
			return FALSE;
		}

		return true;
	}
	
	public function registerLoaderFinder($loader)
	{
		$result = $this->checkLoaderFinder($loader);
		if ($result == FALSE) {
			return FALSE;
		}
		
		$this->loaderFinders[] = $loader;
		return TRUE;
	}

	public function registerType($type, $loader = NULL)
	{
		if (! array_key_exists($type, $this->loaders)) {
			$result = @include_once('model/' . $type . '.class.php');
			if ($result != 1) {
				trigger_error('The requested type ' . $type . ' is not supported', E_USER_WARNING);
				return FALSE;
			}
			if ($loader != NULL) {
				$this->checkLoader($loader);
			}
			$this->loaders[$type] = $loader;
		} else {
			trigger_error('The type requested has already been registered', E_USER_NOTICE);
		}
		
		return TRUE;
	}

	public function manufacture($type)
	{
		if (isset($this->loaders[$type]) && $this->loaders[$type] != NULL) {
			return $this->loaders[$type];
		}

		foreach ($this->loaderFinders as $finder) {
			$loader = $finder->find($type);
			if ($loader != NULL) {
				return $loader;
			}
		}
		
		return NULL;
	}
}

?>