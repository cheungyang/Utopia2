<?php
class Validator
{
	private $_inputs;//inputs: array(key: value)
	private $_spec;	//spec: name -> array( default, validators)
		
	public function __construct($inputs, $spec)
	{
		$this->_inputs = $inputs;
		$this->_spec = $spec;			
	}

	final public function execute()
	{
		try{
			$inputs = $this->_inputs;
			$spec = $this->_spec;
		    $filter = array();    
	    	$inputkeys = array_keys($inputs);
	    	foreach ($spec as $specname => $specopt)
		    {
		    	//check required field, add default if necessary
		    	if (!isset($inputs[$specname]))
		    	{
		    		if (isset($specopt['required']) && $specopt['required'])
		    		{
		    			$rtn['errors'][] = new Exception("required field '$specname' missing", ERROR_REQUIRED_MISSING);
		    		}	
		    		elseif (isset($specopt['default']) && !empty($specopt['default']))
		    		{
		    			$inputs[$specname] = $specopt['default'];
		    		}		
		    	}
			
		    	if (isset($inputs[$specname]))
		    	{
			    	//filering default/input data
			    	$allfilters = isset($specopt['filters'])? $specopt['filters']: array();
			    	if (empty($allfilters))
			    	{
			    		$filter[$specname] = $inputs[$specname];
			    	}
			    	else
			    	{
				    	foreach($allfilters as $filtername => $filteropts)
				    	{
				    		$filterClass = FilterFactory::getFilter($filtername);
				    		$filterrtn = $filterClass->execute($inputs[$specname], $filteropts);
				    		if ($filterrtn['status'] === FAIL)
				    		{
				    			$rtn['errors'] = array_merge($rtn['errors'], $filterrtn['errors']);
				    		}
				    		else
				    		{
				    			$filter[$specname] = $rtn['data'];
				    		}
				    	}
			    	}
		    	}
		    } 						
		}
		catch(Exception $e)
		{
			$rtn['errors'][] = $e; 
		}
		
		$rtn['data'] = $filter;		
		$rtn['status'] = empty($rtn['errors'])? SUCCESS: FAIL;
		return $rtn;
	}
}
?>