<?php
class InputWidget extends BaseWidget implements IWidget
{
	static protected $_inputspec = array(
		'accept'	=> array('type'=>array('file'), 'values'=>''),
		'alt'		=> array('type'=>array('image')),
		'checked'	=> array('type'=>array('checkbox','radio'), 'values'=>array('checked')),
		'disabled'	=> array('type'=>'', 'values'=>array('disabled')),
		'maxlength'	=> array('type'=>array('text','password'), 'values'=>''),
		'name'		=> '',
		'readonly'	=> array('type'=>array('text','password'), 'values'=>array('readonly')),
		'size'		=> '',
		'src'		=> '',
		'type'		=> array('type'=>'', 'values'=>array('button','checkbox','file','hidden','image','password','radio','reset','submit','text')),
		'value'		=> '',
		'accesskey'	=> '',
		'class'		=> '',
		'dir'		=> '',
		'id'		=> '',
		'lang'		=> '',
		'style'		=> '',
		'tabindex'	=> '',
		'title'		=> '',
		'xml:lang'	=> '',
	);
	static protected $_inputspeckeys = array();

	public function __construct()
	{
		parent::__construct();
		self::$_inputspeckeys = array_keys(self::$_inputspec);
	}

	protected function doExecute()
	{
		throw new Exception("filter '".get_class($this)."' has not been implemented.", ERROR_NOT_IMPLEMENTED);
	}

	protected function filterSpec($type)
	{
		$set = array();
		$set['name'] = $this->_name;
		$set['type'] = $type;
		$set['id'] = str_replace(array('[',']'), array('_',''), $this->_name);
		if (isset($this->_spec['opts']) && !empty($this->_spec['opts']))
		{
			foreach($this->_spec['opts'] as $key=>$value)
			{
				if (!in_array($key, self::$_inputspeckeys))	//invalid opt name
				{
					continue;
				}
				if (empty(self::$_inputspec[$key]))		//bypass
				{
					$set[$key] = $value;
				}
				elseif ((empty(self::$_inputspec[$key]['type']) || in_array($type,self::$_inputspec[$key]['type']))	//valid type
					&& (empty(self::$_inputspec[$key]['values']) || in_array($value,self::$_inputspec[$key]['values'])))	//valid value
				{
					$set[$key] = $value;
				}
			}
		}
		
		//print result
		$str = '';
		foreach($set as $name => $value)
		{
			$str .= "$name=\"$value\" ";
		}
		return sprintf("<input %s />", $str);
	}
}
?>
