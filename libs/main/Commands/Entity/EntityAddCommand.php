<?php
class EntityAddCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_add';
	
	protected function doCommand()
	{	
		$settings = SettingFactory::getSettings();	
		$schematext = 'schema_'. strtoupper($this->_params['property']). '_'. strtoupper($this->_params['model']);

		
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
			$inentity = array();
			$inentity['model'] 	= $this->_params['model'];
			$inentity['property'] = $this->_params['property'];
			$inentity['name'] 	= $this->_params['name'];
			$inentity['is_active']= $filtered['is_active'];
			$inentity['is_block'] = $filtered['is_block'];
			$inentity['is_close'] = $filtered['is_close'];
			$inentity['is_delete']= $filtered['is_delete'];

			//get datasource
			$this->_ds = DSFactory::getDS($settings->get($schematext.'_datasource'));
			$entity = $this->_ds->create(array('entityname'=>'entity', 'inputs'=>$inentity));
		}	
		
				
		//get model name
		if ($settings->get($schematext.'_properties_versionable', false) && $this->_params['versiondb'])
		{
			$modelname = $this->_params['model'].'_version';
		}
		else
		{
			$modelname = $this->_params['model'];
		}		

		
		//create subentity
		$insubentity = array();
    	foreach ($filtered as $paramkey => $paramval)
    	{
			$insubentity[$paramkey] = $paramval;
    	}   
    	$insubentity['name'] = $this->_params['name'];
    	$insubentity['Entity'] = $entity;
    	
    	
		//get datasource
		$this->_ds = DSFactory::getDS($settings->get($schematext.'_datasource'));
		$subentity = $this->_ds->create(array('entityname'=>$modelname, 'inputs'=>$insubentity));
	    	
   	
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
