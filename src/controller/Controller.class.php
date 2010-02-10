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


require_once('Smarty/Smarty.class.php');

class Controller
{
	private $smarty;

	public function __construct($template_dir, $config_dir, $cache_dir)
	{
		$this->smarty = new Smarty();
		$this->smarty->template_dir = $template_dir;
		$this->smarty->compile_dir = $cache_dir . '/templates_c';
		$this->smarty->cache_dir = $cache_dir . '/cache';
		$this->smarty->config_dir = $config_dir;

		if (! is_dir($this->smarty->compile_dir)) {
			mkdir($this->smarty->compile_dir, 0700, true);
		}
		if (! is_dir($this->smarty->cache_dir)) {
			mkdir($this->smarty->cache_dir, 0700, true);
		}

		$this->smarty->caching = true;
		$this->smarty->cache_lifetime = 1200;
		$this->smarty->cache_modified_check = true;
		$this->smarty->left_delimiter='{';
		$this->smarty->right_delimiter='}';
	}

	public function set($name, $value)
	{
		$this->smarty->assign($name, $value);
	}

	public function forward($template, $parameters)
	{
		$template_file = $template . '.tpl';
		if (! is_file($this->smarty->template_dir . '/' . $template_file)) {
			trigger_error('There is no template file for ' . $template);			
		}	

		foreach ($parameters as $k => $v) {
			$this->set($k, $v);
		}
		
		$output = '';
		$output .= $this->smarty->fetch('header.tpl');
		$output .= $this->smarty->fetch($template_file);
		$output .= $this->smarty->fetch('footer.tpl');
		
		echo $output;
	}
	
	public function process($object, $operation, $args)
	{
		$object = ucfirst($object);
		require_once('controller/actions/' . $object . '.action.php');
		$className = $object . 'Action';
		$action = new $className();
		$parameters = $action->$operation($args);
		
		$this->set('appName', 'Deadlines');
		$this->set('appVersion', '1.0');
		$this->set('appObject', $object);
		$this->set('appOperation', $operation);
		$this->set('appTheme', 'ironiacorp');
			
		$this->forward($object . '.' . $operation, $parameters);
	}
}

?>
