<?php
class HelperFactory
{
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

			if (file_exists($filenamefull))
			{
				include_once($filenamefull);
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
