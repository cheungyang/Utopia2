<?php
class HelperFactory
{
	private static $_addedhelpers = array();
	
	static public function getHelpers($names)
	{
		if (!is_array($names))
		{
			$tmpnames[] = $names;
			$names = $tmpnames;
		}
		
		$cannotload = array(); 
		foreach($names as $name)
		{
			$filename = ucfirst(strtolower($name)).'Helper';
			$filenamefull = dirname(__FILE__).'/'.$filename.'.php';

			if (file_exists($filenamefull) && !in_array($name, self::$_addedhelpers))
			{
				include_once($filenamefull);
				self::$_addedhelpers[] = $name;
				debug("[found] $filenamefull");
			}
			else
			{
				$cannotload[] = $filename;
			}
		}
		
		if (!empty($cannotload))
		{
			throw new Exception("helper(s) '". implode(', ',$cannotload) ."' not exist", ERROR_CLASS_NOT_EXIST);
		}
		return true;
	}
}
?>
