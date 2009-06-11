<?php
class EmailFilter extends BaseFilter implements IFilter
{ 
	protected function doFilter()
	{
		if (is_array($this->_inputs))
		{
			throw new Exception("input cannot be an Array", ERROR_TYPE_MISMATCH);
		}
		
		// source: http://www.addedbytes.com/php/email-address-validation
		// First, we check that there's one @ symbol, 
		// and that the lengths are right.
	  	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $this->_inputs)) 
	  	{
	    	// Email invalid because wrong number of characters 
		    // in one section or wrong number of @ symbols.
		    throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}: number of characters in one section or wrong number of @ symbols", ERROR_VALIDATION);
	  	}
  		// Split it into sections to make life easier
  		$email_array = explode("@", $this->_inputs);
  		$local_array = explode(".", $email_array[0]);
  		for ($i = 0; $i < sizeof($local_array); $i++) 
  		{
  			$pattern = "^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$";
    		if (!ereg($pattern, $local_array[$i])) 
    		{
      			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}: local_array error", ERROR_VALIDATION);
    		}
  		}
  		// Check if domain is IP. If not, 
  		// it should be valid domain name
  		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) 
  		{
    		$domain_array = explode(".", $email_array[1]);
    		if (sizeof($domain_array) < 2) 
    		{
    			// Not enough parts to domain
    			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}: Not enough parts to domain", ERROR_VALIDATION); 
    		}
    		for ($i = 0; $i < sizeof($domain_array); $i++) 
    		{
    			$pattern = "^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$";
      			if (!ereg($pattern, $domain_array[$i])) 
      			{
        			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}: domain_array error", ERROR_VALIDATION);
      			}
    		}
  		}
		return $this->_inputs;		
	
	}
	
}
?>