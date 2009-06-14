<?php
class FilterFactory
{	
	private static $instances = array();
	
	static public function getFilter($name)
	{
		if (isset(self::$instances[$name]))
			return self::$instances[$name];
		
		$filtername = ucfirst(strtolower($name)).'Filter';
		if (class_exists($filtername))
		{
			self::$instances[$name] = new $filtername();
			return self::$instances[$name];
		} 
		else
		{
			throw new Exception("class '$filtername' not exist", ERROR_CLASS_NOT_EXIST);
		} 		
	}
}
?>