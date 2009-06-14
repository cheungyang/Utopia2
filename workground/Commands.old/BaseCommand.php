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
	
  	protected function getMaxVersionCount($idx)
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();			
		$schematext = 'schema_'.$this->_params['model'];
				
		//throw if model not versionable
		if (!$settings->get($schematext.'_properties_versionable', false))
		{
			throw new Exception("cannot find version count, model {$this->_params['model']} not versionable.", ERROR_NOT_VERSIONABLE);
		}	
		
		//validate inputs
		$spec = array('id' => array('required' => true));
		if ($settings->get($schematext.'_properties_translateable', false))
		{
			$spec['cult'] = array('required'=>true);
		}
		if ($settings->get($schematext.'_properties_chainable', false)) 
		{
			$spec['seq'] = array('required'=>true);
		}		
		$validator = ValidatorFactory::getValidator($idx, $spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === SUCCESS)
		{
			$filtered = $validatorrtn['data'];			
		}
		else
		{
			//TODO: throw all errors 
			throw $validatorrtn['errors'][0];
		}	
		
		$modelname = ucfirst(strtolower($this->_params['model'])).'_version';
		$q = Doctrine_Query::create()
			->select('max(m.version) AS MAX')
			->from("$modelname m")
			->where('m.entity_id=?', $filtered['id']);
			//->leftJoin('m.Entity e')
			//->where('e.property=?', $this->_params['property'])
			//->andWhere('e.id=?',$filtered['id']);
    	if (isset($filtered['cult']))
    	{
      		$q->andWhere('m.cult=?', $filtered['cult']);
    	}
    	if (isset($filtered['seq']))
    	{
      		$q->andWhere('m.seq=?', $filtered['seq']);
    	}    	
     
		$rtnquery = $q->execute();
		if (isset($rtnquery[0]['MAX']))
		{
    		return $rtnquery[0]['MAX'];
		}
		else
		{	
			return 1;
			//throw new Exception('execution error, query: '. $q->getSql(), ERROR_RETURN_PROBLEM);
		}
	}
  
  	protected function getMaxSeqCount($idx)
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();			
		$schematext = 'schema_'.$this->_params['model'];
				
		//throw if model not versionable
		if (!$settings->get($schematext.'_properties_chainable', false))
		{
			throw new Exception("cannot find seq count, model {$this->_params['model']} not chainable.", ERROR_NOT_CHAINABLE);
		}	
		
		//validate inputs
		$spec = array('id' => array('required' => true));
		if ($settings->get($schematext.'_properties_translateable', false))
		{
			$spec['cult'] = array('required'=>true);
		}		
		$validator = ValidatorFactory::getValidator($idx, $spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === SUCCESS)
		{
			$filtered = $validatorrtn['data'];			
		}
		else
		{
			//TODO: throw all errors 
			throw $validatorrtn['errors'][0];
		}	
		
		$modelname = $settings->get($schematext.'_properties_versionable', false)?
			ucfirst(strtolower($this->_params['model'])).'_version':
			ucfirst(strtolower($this->_params['model']));
		$q = Doctrine_Query::create()
			->select('max(m.seq) AS MAX')
			->from("$modelname m")
			->where('m.entity_id=?', $filtered['id']);
			//->leftJoin('m.Entity e')
			//->where('e.property=?', $this->_params['property'])
			//->andWhere('e.id=?',$filtered['id']);
    	if (isset($filtered['cult']))
    	{
      		$q->andWhere('m.cult=?', $filtered['cult']);
    	}
     
		$rtnquery = $q->execute();
		if (isset($rtnquery[0]['MAX']))
		{
    		return $rtnquery[0]['MAX'];
		}
		else
		{	
			return 1;			
			//throw new Exception('execution error, query: '. $q->getSql(), ERROR_RETURN_PROBLEM);
		}
	}

  	protected function getDistinctLanguages($idx)
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();			
		$schematext = 'schema_'.$this->_params['model'];
				
		//throw if model not versionable
		if (!$settings->get($schematext.'_properties_translateable', false))
		{
			throw new Exception("cannot find distinct languages, model {$this->_params['model']} not translateable.", ERROR_NOT_TRANSLATEABLE);
		}	
		
		//validate inputs
		$spec = array('id' => array('required' => true));
		$validator = ValidatorFactory::getValidator($idx, $spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === SUCCESS)
		{
			$filtered = $validatorrtn['data'];			
		}
		else
		{
			//TODO: throw all errors 
			throw $validatorrtn['errors'][0];
		}	
		
		$modelname = $settings->get($schematext.'_properties_versionable', false)?
			ucfirst(strtolower($this->_params['model'])).'_version':
			ucfirst(strtolower($this->_params['model']));
		$q = Doctrine_Query::create()
			->select('distinct(m.cult) AS cult')
			->from("$modelname m")
			->where('m.entity_id=?', $filtered['id']);
			//->leftJoin('m.Entity e')
			//->where('e.property=?', $this->_params['property'])
			//->andWhere('e.id=?',$filtered['id']);
		$rtnquery = $q->execute();
		if (count($rtnquery) > 0)
		{
		    $rtnarr = array();
		    foreach ($rtnquery as $rtnobj)
				$rtnarr[] = $rtnobj['cult'];
		}
		else
		{	
			return array();
			//throw new Exception('execution error, query: '. $q->getSql(), ERROR_RETURN_PROBLEM);
		}		
	}
}
?>