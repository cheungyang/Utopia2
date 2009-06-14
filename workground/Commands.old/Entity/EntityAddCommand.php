<?php
class EntityAddCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_add';
	
	protected function doCommand()
	{	
		$settings = SettingFactory::getSettings();
		$settings->getConnection();		
		$schematext = "schema_". strtoupper($this->_params['property']). "_". strtoupper($this->_params['model']);
		
		//get datasource class
		$dsnane = ucfirst($settings->get($schematext.'_datasource')). 'DS';
		if (!class_exists($dsname))
		{
			throw new Exception("class '$classname' not exist", ERROR_CLASS_NOT_EXIST);
		}
		$this->_ds = new $dsname();

		
		//validation
		$required = array();
		if ($settings->get($schematext.'_properties_translateable', false))
		{
			$required['cult'] = array('required'=>true);
			if (isset($this->_params['id']) && $this->_params['newcult'])
			{
				$existlangs = $this->getDistinctLanguages($this->_params);
				//TODO: add validator, cult should be not be in existlangs
			} 
		}
		if ($settings->get($schematext.'_properties_chainable', false)) 
		{
			$params = array_merge($this->_params['inputs'], $this->_params);
			if (isset($this->_params['id']))	//existing entity
			{
				$maxseq = $this->_params['newseq']? $this->getMaxSeqCount($params)+1: $this->getMaxSeqCount($params);
			}
			else	//new entity
			{
				$maxseq = 1;
			}
			$required['seq'] = array('default'=>$maxseq);
		}
		if ($settings->get($schematext.'_properties_versionable', false))
		{
			$params = array_merge($this->_params['inputs'], $this->_params);
			if (isset($this->_params['id']))	//existing entity
			{
				$maxversion = $this->_params['newversion']? $this->getMaxVersionCount($params)+1: $this->getMaxVersionCount($params);
			}
			else	//new entity
			{
				$maxversion = 1;
			}			
			$required['version'] = array('default'=>$maxversion);
		}		
		$spec = array_merge(
			array(
				'is_active' => array('default'=>'1'),
				'is_block' 	=> array('default'=>'0'),
				'is_close'  => array('default'=>'0'),
				'is_delete' => array('default'=>'0'),
			), 
			$required,
			$settings->get($schematext.'_columns')
		);
	
		$validator = ValidatorFactory::getValidator($this->_params['inputs'], $spec);
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
		
		//if has id, check if the exact same record exists
		if (isset($this->_params['id']))
		{		
		    $params = array(
		    	'property' 	=> $this->_params['property'],
	      		'model'		=> $this->_params['model'],
	      		'ids'		=> $this->_params['id'],
	      		'restricted'=> false,
	      		'versiondb'	=> $this->_params['versiondb']);
		   	if (isset($filtered['version'])) 	$params['version'] = $filtered['version'];
		   	if (isset($filtered['cult'])) 		$params['cult'] = $filtered['cult'];
		   	if (isset($filtered['seq'])) 		$params['seq'] = $filtered['seq'];
			$commandname = strtolower($this->_params['model']).'_fetch';
			$command = CommandFactory::getCommand($commandname, $params);
			$commandrtn = $command->execute();

			if ($commandrtn['status'] === FAIL)
			{
				//TODO: throw all errors 
				throw $commandrtn['errors'][0];
			}
			elseif ($commandrtn['data']['total'] != 0)
			{
				throw new Exception("cannot add new record, the exact same record exists with parameters: ". print_r($params, true), ERROR_RECORD_EXISTS);
			}
		}

		//if has id, get entity
		if (isset($this->_params['id']))
		{
			$params = array(
		    	'property' 	=> $this->_params['property'],
	      		'model'		=> NAME_ENTITY,
	      		'ids'		=> $this->_params['id'],
	      		'restricted'=> false,
	      		'versiondb'	=> false);
			$commandname = strtolower($this->_params['model']).'_fetch';
			$command = CommandFactory::getCommand($commandname, $params);
			$commandrtn = $command->execute();
			if ($commandrtn['status'] === FAIL)
			{
				//TODO: throw all errors 
				throw $commandrtn['errors'][0];
			}
			elseif ($commandrtn['data']['total'] == 0)
			{
				throw new Exception("zero record fetched with parameters: ". print_r($params, true), ERROR_EMPTY_RESULT);
			}
			elseif ($commandrtn['data']['total'] > 1)
			{
				throw new Exception("more than 1 record fetched with parameters: ". print_r($params, true), ERROR_MULTIPLE_RESULTS);
			} 
			$entity = $commandrtn['data']['entities'][0];
		}
		else
		{
			//create entity		
			$entity = new Entity();
			$entity['model'] 	= $this->_params['model'];
			$entity['property'] = $this->_params['property'];
			$entity['name'] 	= $this->_params['name'];
			$entity['is_active']= $filtered['is_active'];
			$entity['is_block'] = $filtered['is_block'];
			$entity['is_close'] = $filtered['is_close'];
			$entity['is_delete']= $filtered['is_delete'];
			$entity->save();
		}	
		
		//get model name
		if ($settings->get($schematext.'_properties_versionable', false) && $this->_params['versiondb'])
		{
			$modelname = ucfirst(strtolower($this->_params['model'])).'_version';
		}
		else
		{
			$modelname = ucfirst(strtolower($this->_params['model']));
		}		
		if (!class_exists($modelname))
		{
			throw new Exception("model class '$modelname' does not exist.", ERROR_CLASS_NOT_EXIST);
		}	
			
		//create subentity
		$subentity = new $modelname();
    	foreach ($filtered as $paramkey => $paramval)
    	{
			$subentity[$paramkey] = $paramval;
    	}   
    	$subentity['name'] = $this->_params['name'];
    	$subentity['Entity'] = $entity;
    	$subentity->save();
    	
    	//if versionable and in version db, revert this to main db
    	if ($settings->get($schematext.'_properties_versionable', false) && $this->_params['versiondb'])
    	{
			$params = array(
		    	'property' 	=> $this->_params['property'],
	      		'model'		=> $this->_params['model'],
	      		'id'		=> $entity['id']);
		   	if (isset($subentity['version'])) 	$params['version'] = $subentity['version'];
		   	if (isset($subentity['cult'])) 		$params['cult'] = $subentity['cult'];
		   	if (isset($subentity['seq'])) 		$params['seq'] = $subentity['seq'];			
    		$commandname = strtolower($this->_params['model']).'_revert';
			$command = CommandFactory::getCommand($commandname, $params);
			$commandrtn = $command->execute();
			if ($commandrtn['status'] === FAIL)
			{
				//TODO: throw all errors 
				throw $commandrtn['errors'][0];
			}		
    	}
    	
    	//return added subentity
   		return $subentity->toArray();
	} 	
}
?>
