<?php 
class HandlerFactory
{
	static public function getHandler($name, $params)
	{
		$classname = ucfirst(strtolower($name)).'Handler';
		if (class_exists($classname))
		{
			return new $classname($params);
		}
		else
		{
			throw new Excepion("class '$classname' not exist", ERROR_CLASS_NOT_EXIST);
		}
	}
}
?>