<?php
class BaseCommand
{
	protected $_params=array(), $_stained;
	protected $_name = '###NEED TO BE REPLACED###';
	
	public function __construct($params=array())
	{
		$this->_stained = $params;
	}
	
	final public function execute()
	{
		$rtn = array('errors'=>array());
		
		try
		{
			$settings = SettingFactory::getSettings();
			$this->_stained['property'] = $settings->getDimension('property');				
			$spec = $settings->get('command_'.$this->_name.'_params');
			
			$validator = ValidatorFactory::getValidator($this->_stained, $spec);
			$validatorrtn = $validator->execute();
			if ($validatorrtn['status'] === SUCCESS)
			{
				$this->_params = $validatorrtn['data'];
				$commandrtn = $this->doCommand();
				if (empty($commandrtn))
				{
					throw new Exception("doCommend returns empty.", ERROR_EMPTY_RESULT);
				}
				else
				{
					$rtn['data'] = $commandrtn;
				}
			}
			else
			{
				$rtn['errors'] = array_merge($rtn['errors'], $validatorrtn['errors']);
			}
		}
		catch(Exception $e)
		{
			$rtn['data'] = array();
			$rtn['errors'][] = $e;
		}
							
		$rtn['status'] = empty($rtn['data'])? FAIL: SUCCESS;
		$rtn['inputs'] = $this->_params;
		return $rtn;		
	}
		
	protected function doCommand()
	{
		throw new Exception("command '".$this->_name."' has not been implemented.", ERROR_NOT_IMPLEMENTED);
	}
	

}
?>