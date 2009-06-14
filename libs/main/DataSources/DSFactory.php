<?php
class DataSourceFactory
{
	private static $instances = array();
	
	static public function getDS($name)
	{
		if (isset(self::$instances[$name]))
			return self::$instances[$name];
		
		$dsname = ucfirst(strtolower($name)).'DS';
		if (class_exists($dsname))
		{
			self::$instances[$name] = new $dsname();
			return self::$instances[$name];
		} 
		else
		{
			throw new Exception("class '$dsname' not exist", ERROR_CLASS_NOT_EXIST);
		} 		
	}
}
?>