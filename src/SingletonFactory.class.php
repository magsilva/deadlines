<?

require_once('Factory.interface.php');

abstract class SingletonFactory implements Factory
{
	private static $singletons;

	private static $loaders;

        public function __construct()
        {
		self::$singletons = array();
		self::$loaders = array();
	}

	public function register($type, $loader)
	{
		if (! isset(self::$singletons[$type])) {
			$result = include_once($type . '.class.php');
			if ($result != 1) {
				trigger_error('The class type requested is not supported', E_USER_ERROR);
			}
			self::$singletons[$type] = array();
		}

		if (! isset(self::$loaders[$type])) {
			$interfaces = class_implements($loader, false);
			if ($interfaces === FALSE || ! in_array('DAO', $interfaces)) {
				trigger_error('Loader does not implement any interface (nor the required CRUD interface)', E_USER_ERROR);
			}
			self::$loaders[$type] = $loader;
		}
        }

	public function manufacture($type, $id)
	{
		if (! isset(self::$loaders[$type])) {
			trigger_error('Unsupported object type');
		}

		if (isset(self::$singletons[$type][$id])) {
			return self::$singletons[$type][$id];
		}
	
		$loader = self::$loaders[$type];
		$object = $loader->read($id);
		self::$singletons[$type][$id] = $object;
		return $object;
	}
}

?>
