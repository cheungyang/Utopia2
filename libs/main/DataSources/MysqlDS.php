<?php
class MysqlDS extends BaseDS implements IDataSource
{
	public function create($params)
	{
		//validate inputs
		$spec = array(
			'entityname'=> array('required'=>true),
			'inputs'	=> array('required'=>true),
		);	
		$validator = ValidatorFactory::getValidator($params, $spec);
		$validatorrtn = $validator->execute();
		if ($validatorrtn['status'] === FAIL)
		{
			//TODO: throw multiple errors
			throw $validatorrtn['errors'][0];
		}
		$filtered = $validatorrtn['data'];
	
		$entname = ucfirst(strtolower($filtered['entityname']));
		if (class_exists($entname))
		{
			$entity = new $entname();
			$entity = array_merge($filtered['entity'], $filtered['inputs']);
			$entity->save();
			return $entity;
		}
		else
		{
			throw new Exception("class '$entname' not exist", ERROR_CLASS_NOT_EXIST);
		}		
	}
	
	
  	public function getMaxVersionCount($idx)
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
  
  	public function getMaxSeqCount($idx)
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

  	public function getDistinctLanguages($idx)
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