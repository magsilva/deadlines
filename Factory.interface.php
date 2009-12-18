<?

require_once('Work_type.class.php');


interface Factory
{
	public function register($obj, $loader);

	public function manufacture($obj_type, $data);
}

?>
