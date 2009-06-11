<?php
class BaseFilter
{
	protected $_inputs, $_opts;
	 
	public function __construct(){}
	
	final public function execute($inputs, $opts)
	{
		$this->_inputs = $inputs;
		$this->_opts = $opts;
		
		try{ 			
			$rtnfilter = $this->doFilter();
			if ($this->_empty($rtnfilter))
			{
				throw new Exception("doFilter returns empty.", ERROR_EMPTY_RESULT);
			}
			else
			{
				$rtn['data'] = $rtnfilter;
			}			
			$rtn['status'] = SUCCESS;
		}catch(Exception $e){
			$rtn['status'] = FAIL;
			$rtn['errors'][] = $e; 
		}
		return $rtn;
	}
	
	protected function doFilter()
	{
		throw new Exception("filter '".get_class($this)."' has not been implemented.", ERROR_NOT_IMPLEMENTED);
	}

	private function _empty($string)
	{
		if (is_array($string))
		{
			return empty($string);
		}
		
		$string = trim($string);
		if(!is_numeric($string))
		{ 
			return empty($string);
		}
		
		return FALSE;
	}
}
?>