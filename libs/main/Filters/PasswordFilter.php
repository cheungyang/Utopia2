<?php
class PasswordFilter extends BaseFilter implements IFilter
{ 
	protected function doFilter()
	{
		if (is_array($this->_inputs))
		{
			throw new Exception("input cannot be an Array", ERROR_TYPE_MISMATCH);
		}
		
		
		//check password strength
		if (isset($this->_opts['strength']))
		{
		    $strength = 0;
		    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[!"$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/');
    		foreach($patterns as $pattern)
    		{
        		if(preg_match($pattern,$this->_inputs))
        		{
         	   		$strength++;
				}	
    		}
    		if ($strength < (int)$this->_opts['strength'])
    		{
    			throw new Exception("insufficient strength, expected {$this->_opts['strength']}, now {$strength}", ERROR_TYPE_MISMATCH);
    		}
		}
    			
		return md5($this->_inputs);
		
	}		
}
?>