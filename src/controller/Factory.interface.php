<?

require_once('model/Work_type.class.php');


interface Factory
{
	public function registerLoaderFinder($loader);
	
	public function registerType($type, $loader = NULL);
	
	public function manufacture($obj_type);
}

?>
