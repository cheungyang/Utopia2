<?php
class NumberFilter extends BaseFilter implements IFilter
{ 
	protected function doFilter()
	{
		if (is_array($this->_inputs))
		{
			throw new Exception("input cannot be an Array", ERROR_TYPE_MISMATCH);
		}
				
		$pattern = 
			'/^[+-]?'. 		// start marker and sign prefix
  			'(((([0-9]+)|([0-9]{1,4}(,[0-9]{3,4})+)))?(\\.[0-9])?([0-9]*)|'.	// american
  			'((([0-9]+)|([0-9]{1,4}(\\.[0-9]{3,4})+)))?(,[0-9])?([0-9]*))'. 	// world
  			'(e[0-9]+)?'. 	// exponent
  			'$/'; 			// end marker
		if (preg_match($pattern, $this->_inputs))
		{
			//TODO: opts: max, min, integer
			return $this->_inputs;
		}
		else
		{
			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}", ERROR_VALIDATION);
		}
	}		
}
?>