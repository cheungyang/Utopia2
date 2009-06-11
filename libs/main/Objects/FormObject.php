<?php
//===========$this->_struct schema pattern===========
//formholder1:
//	fieldname:
//		label: displayname
//		type: input/textarea/...
//		opts: { size: 50, class: inputclass }
//		required: true
//		info: 'this is a field'
//		filters: 
//			numeric: {max: 0, min: 100, integer: true, errmeg: 'numeric validation failure'}
//			string: {type: "chinese|english|both", withnum: true, minlen: 1, maxlen: 100, utf8: true }
//			password: {encrypt: "md5|sda1", strength: 4}
//			trim: ~
//			urlencode: ~
//			str_replace: ['search', 'replace', '%s']
//			email: ~
//			url: ~
//			date: ~
//			match: [pass_confirmation, errmsg: 'does not match']

//===========$this->form pattern============
//formholder:
//	fieldname: 
//		label:
//		type:
//		required:
//		opts:
//		info:
//		errmsg:
class FormObject
{
	protected 	$_struct, 
				$_defaults, $_inputs,
				$_form;

	public function __construct($params)	
	{
		$spec = array('struct'=>array('required'=>true), 'defaults'=>array('required'=>true),);		 
		$validator = ValidatorFactory::getValidator($params, $spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === FAIL)
		{
			throw new Exception("params [struct, defaults] required.", ERROR_INSUFFICIENT_PARAMS);
		}

		$this->_struct = Yaml::load($validatorrtn['data']['struct']);
		$this->_defaults = $validatorrtn['data']['defaults'];
		$this->_inputs = $this->_defaults;
		
		$this->_form = array();
	}

	public function printForm($toString=false)
	{
		$hasfile = false;
		$str = '';
		foreach($this->_struct as $formname => $formfields)
		{
			$rowstr = '';
			foreach($formfields as $fieldname => $fieldopts)
			{
				$rowstr .= "<tr>"
					.$this->label("$formname.$fieldname", "<th rowspan=\"3\">", "</th>", true)
					.$this->error("$formname.$fieldname", "<td colspan=\"2\">", "</td>", true)
					."</tr>"
					."<tr>"	
					.$this->field("$formname.$fieldname", "<td>", "</td>", true)
					.$this->required("$formname.$fieldname", "<td>", "</td>", true)
					."</tr>"
					."<tr>"	
					.$this->info("$formname.$fieldname", "<td colspan=\"2\">", "</td>", true)
					."</tr>";
			}			
			$str = "<table><tr><td colspan=\"3\"><input type=\"submit\"/></td>".$rowstr."</table>";
		}
			 
		$str = $hasfile?
			"<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">$str</form>":
			"<form action=\"\" method=\"POST\">$str</form>";
		
		if ($toString)
		{
			return $str;
		}
		else
		{
			echo $str;
			return true;
		}
			
	}

	public function get($name)
	{
		$fieldinfo = $this->_getStruct($name);
		if (is_null($fieldinfo))
		{
			return '';			
		}
		else
		{
			return $fieldinfo;
		}
	}
	
	public function input($inputs)
	{
		$this->_inputs = array_merge($inputs, $this->_defaults);
	}
	
	public function toArray(){}

	public function validate()
	{
		$errors = array();
		$data = array();
		foreach ($this->_struct as $holdername => $holderfields)
		{
			$spec = array();				
			foreach($holderfields as $fieldname => $fieldopts)
			{
				$spec[$fieldname] = $fieldotps['filter'];
			}	
			$validator = ValidatorFactory::getValidator($this->_inputs, $spec);
			$validatorrtn = $validator->execute();
			if ($validatorrtn['status'] === FAIL)
			{
				//TODO insert errmsg
				$errors = array_merrge($errors, $validatorrtn['errors']);
				$data = array_merrge($data, $validatorrtn['data']);
			}
		}

		if (empty($errors))
		{
			return array(
				'status' => FAIL, 
				'errors' => $errors,
			);
		}
		else
		{
			return array(
				'status' => SUCCESS, 
				'data'	 => $data,
			);
		}
	}	
	
	public function label($name, $opentag='', $closetag='', $toString=false)
	{
		$spec = $this->_getStruct($name);
		$widget = WidgetFactory::getWidget('label');
		$widgetrtn = $widget->execute($name, $spec);
		$rtnstr = $widgetrtn['status'] === FAIL? '<span class="error">##ERROR##</span>': $widgetrtn['data'];
		return  $opentag . $rtnstr . $closetag;
	}

	public function field($name, $opentag='', $closetag='', $toString=false)
	{
		$spec = $this->_getStruct($name);
		$widget = WidgetFactory::getWidget($spec['type']);
		$widgetrtn = $widget->execute($name, $spec);
		$rtnstr = $widgetrtn['status'] === FAIL? '<span class="error">##ERROR##</span>': $widgetrtn['data'];
		return  $opentag . $rtnstr . $closetag;		
	}

	public function info($name, $opentag='', $closetag='', $toString=false)
	{
		$spec = $this->_getStruct($name);
		$widget = WidgetFactory::getWidget('info');
		$widgetrtn = $widget->execute($name, $spec);
		$rtnstr = $widgetrtn['status'] === FAIL? '<span class="error">##ERROR##</span>': $widgetrtn['data'];
		return  $opentag . $rtnstr . $closetag;
	}

	public function required($name, $opentag='', $closetag='', $toString=false)
	{
		$spec = $this->_getStruct($name);
		$widget = WidgetFactory::getWidget('required');
		$widgetrtn = $widget->execute($name, $spec);
		$rtnstr = $widgetrtn['status'] === FAIL? '<span class="error">##ERROR##</span>': $widgetrtn['data'];
		return  $opentag . $rtnstr . $closetag;
	}

	public function error($name, $opentag='', $closetag='', $toString=false){}

	public function errors($name, $opentag='', $closetag='', $toString=false){}



	//need to check is_null everytime when using this function
	//return pointer for modifications
	protected function & _getStruct($name)
	{
		$keys = explode('.',$name);
		$var = $this->_struct;
		foreach($keys as $key)
		{
			if (isset($var[$key]))
			{
				$var = $var[$key];
			}
			else
			{
				return null;
			}
		}
		return $var;
	}

	protected function _hasFile()
	{
		foreach($this->_struct as $field)
		{
			foreach($field as $opts)
			{
				if (isset($opts['type']) && strtolower($opts['type']) == 'file')
					return true;
			}
		}
		return false;
	}
	
	protected function _formulateData($inputs=null)
	{
		if (is_null($inputs))
		{
			$inputs = $this->_defaults;
		}
		else
		{
			$this->_inputs = $inputs;			
		}
				
		$form = array();
		foreach($this->_struct as $holdername => $holderfields)
		{
			foreach($holderfields as $fieldname => $fieldopts)
			{
				$form[$holdername] = array(
					'label'		=> $fieldopts['label'],
					'type'		=> $fieldopts['type'],
					'required'	=> $fieldopts['required'],
					'opts'		=> $fieldopts['opts'],
					'info'		=> $fieldopts['info'],	
					'errmsg'	=> '',
				);				
			}
		}	
		$this->_form = $form;
	}
}
?>
