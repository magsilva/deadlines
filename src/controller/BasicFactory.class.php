<?php

require_once('controller/Factory.interface.php');

class BasicFactory implements Factory
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
		if ($interfaces === FALSE || ! in_array('Loader_Finder', $interfaces)) {
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
