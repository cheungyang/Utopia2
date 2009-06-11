<?php
class CommandFactory
{
	static function getCommand($name, $params)
	{
		$settings = SettingFactory::getSettings();	
		$commandinfo = $settings->get('command_'.$name);

		$params = array_merge($commandinfo['params'], $params);
		$classname = $commandinfo['class'];
		if (class_exists($classname))
		{
			return new $classname($params);
		}
		else
		{
			throw new Exception("class '$classname' not exist", ERROR_CLASS_NOT_EXIST);
		} 
	}
}
?>