<?php
class EntityRevertCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_revert';
	
	protected function doCommand()
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();		
		$schematext = 'schema_'.$this->_params['model'];
		//throw if model not versionable
		if (!$settings->get($schematext.'_properties_versionable', false))
		{
			throw new Exception("model {$this->_params['model']} not versionable.", ERROR_NOT_VERSIONABLE);
		}	
		
		//get latest version/ version to revert, check condition
	    $params = array(
	    	'property' 	=> $this->_params['property'],
      		'model'		=> $this->_params['model'],
      		'ids'		=> $this->_params['id'],
      		'restricted'=> true,	//can only revert valid(not deleted) records
      		'versiondb'	=> true);
	   	if (isset($this->_params['version'])) 	$params['version'] = $this->_params['version'];
	   	if (isset($this->_params['cult'])) 		$params['cult'] = $this->_params['cult'];
	   	if (isset($this->_params['seq'])) 		$params['seq'] = $this->_params['seq'];
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
		$version_record = $commandrtn['data']['entities'][0];
		
		//get main db record
	    $params = array(
	    	'property' 	=> $this->_params['property'],
      		'model'		=> $this->_params['model'],
      		'ids'		=> $this->_params['id'],
      		'restricted'=> false,	//can only revert valid(not deleted) records
      		'versiondb'	=> false);
	   	if (isset($this->_params['cult'])) 		$params['cult'] = $this->_params['cult'];
	   	if (isset($this->_params['seq'])) 		$params['seq'] = $this->_params['seq'];
	   	//no version  - there should only be one version at main db, error if more than one
		$commandname = strtolower($this->_params['model']).'_fetch';
		$command = CommandFactory::getCommand($commandname, $params);
		$commandrtn = $command->execute();
		if ($commandrtn['status'] === FAIL)
		{
			//TODO: throw all errors 
			throw $commandrtn['errors'][0];
		}
		elseif ($commandrtn['data']['total'] > 1)	//error
		{
			throw new Exception("more than 1 record fetched with parameters: ". print_r($params, true), ERROR_MULTIPLE_RESULTS);
		} 		
		elseif ($commandrtn['data']['total'] == 0)	//create one for main db
		{			
			$params = array(
		    	'property' 	=> $this->_params['property'],
	      		'model'		=> $this->_params['model'],
				'name'		=> $version_record['name'],
				'id'		=> $this->_params['id'], 
				'inputs'	=> $version_record->toArray(),
				'versiondb'	=> false	//important: write at main db
			);			
			$commandname = strtolower($this->_params['model']).'_add';
			$command = CommandFactory::getCommand($commandname, $params);
			$commandrtn = $command->execute();
			if ($commandrtn['status'] === FAIL)
			{
				//TODO: throw all errors 
				throw $commandrtn['errors'][0];
			}
			return $commandrtn['data'];
		}
		else	//revert to current
		{
			$maindb_record = $commandrtn['data']['entities'][0];
			$version_record_array = $version_record->toArray();
			unset($version_record_array['id'], $version_record_array['entity_id'], $version_record_array['Entity']);
			foreach($version_record_array as $key => $value)
			{
				$maindb_record[$key] = $value;
			}
			$maindb_record->save();
			return $maindb_record->toArray();
		}			
	} 	
}
?>
