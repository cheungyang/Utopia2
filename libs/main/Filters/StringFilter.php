<?php
class StringFilter extends BaseFilter implements IFilter
{ 
	protected function doFilter()
	{
		if (is_array($this->_inputs))
		{
			throw new Exception("input cannot be an Array", ERROR_TYPE_MISMATCH);
		}
		
		$inputs = iconv('','UTF-8', $this->_inputs);
		$pattern = "/^[\x80-\xff_a-zA-Z]{3,15}/";  //FIXME: this is not a good one...see test
		if (preg_match($pattern, $inputs))
		{
			//TODO: max, min, chinese, english, strict(english/chinese only), trim
			return $inputs;
		}
		else
		{
			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}", ERROR_VALIDATION);
		}
	}		
}
?>