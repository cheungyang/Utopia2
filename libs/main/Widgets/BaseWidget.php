<?php
class BaseWidget
{
	static protected $_defaultspec = array(
		'label' 	=> '##labelname##',
		'type'		=> 'input',
		'required' 	=> false,
		'opts'		=> array(),
		'info'		=> '',
		'errmsg'	=> ''
	);
	protected $_spec, $_name;
	
	public function __construct(){}

	final public function execute($fieldname, $fieldspec, $default=null)//fieldname: form[input]
	{
		$this->_name = $fieldname;
		$this->_spec = array_merge(self::$_defaultspec, $fieldspec);
		try
		{
			$rtnwidget = $this->doExecute();
			if (empty($rtnwidget))
			{
				throw new Exception("doExecute returns empty.", ERROR_EMPTY_RESULT);
			}
			else
			{
				$rtn['data'] = $rtnwidget;
			}			
			$rtn['status'] = SUCCESS;
		}
		catch(Exception $e)
		{
			$rtn['status'] = FAIL;
			$rtn['errors'][] = $e;
		}
		return $rtn;
	}	

	protected function doExecute()
	{
		throw new Exception("widget '".get_class($this)."' has not been implemented.", ERROR_NOT_IMPLEMENTED);
	}
}
?>
