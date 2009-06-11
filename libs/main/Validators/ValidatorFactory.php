<?php
class ValidatorFactory
{	
	static public function getValidator($inputs, $spec)
	{
		$classname = 'Validator';
		if (class_exists($classname))
		{
			return new $classname($inputs, $spec);
		}
		else
		{
			throw new Excepion("class '$classname' not exist", ERROR_CLASS_NOT_EXIST);
		} 		
	}
}
?>