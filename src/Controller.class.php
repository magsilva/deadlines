<?

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

	public function forward($template)
	{
		static $cache_info = array();

		$template_file = $template . '.tpl';
		if (! is_file($this->smarty->template_dir . '/' . $template_file)) {
			trigger_error('There is no template file for ' . $template);			
		}	

		$output = '';
		$output .= $this->smarty->fetch('header.tpl');
		$output .= $this->smarty->fetch($template_file);
		$output .= $this->smarty->fetch('footer.tpl');

		echo $output;
	}
}

?>
