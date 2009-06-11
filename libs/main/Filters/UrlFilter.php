<?php
class UrlFilter extends BaseFilter implements IFilter
{ 
	protected function doFilter()
	{
		if (is_array($this->_inputs))
		{
			throw new Exception("input cannot be an Array", ERROR_TYPE_MISMATCH);
		}
				
		$pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i'; //FIXME bad regexp, see test
		if (preg_match($pattern, $this->_inputs))
		{
			return $this->_inputs;
		}
		else
		{
			throw new Exception("validator error running ".get_class($this)." for parameter {$this->_inputs}", ERROR_VALIDATION);
		}
	}		
}
?>