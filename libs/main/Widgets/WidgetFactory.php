<?php
class WidgetFactory
{
	static $instances = array();
	
	static public function getWidget($name)
	{
		if (isset(self::$instances[$name]))
		{
			return self::$instances[$name];
		}

		$classname = ucfirst( strtolower($name) ).'Widget';
		if (class_exists($classname))
		{
			$instance = new $classname();
			self::$instances[$name] = $instance;
			return self::$instances[$name];
		}
		else
		{
			throw new Exception("class '$classname' not exist", ERROR_CLASS_NOT_EXIST);
		}
	}
}
?>
