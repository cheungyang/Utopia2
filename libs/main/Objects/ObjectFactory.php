<?php
class ObjectFactory
{
	static public function getObject($name, $params)
	{
		$classname = ucfirst(strtolower($name)).'Object';
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
