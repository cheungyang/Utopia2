<?php
class EntityEditCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_edit';
	
	protected function doCommand()
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();		
		$schematext = 'schema_'.$this->_params['model'];
		$entityfields = array('name','is_active','is_block','is_close','is_delete');

		//check inputs
		$spec = array_fill_keys(
			array_merge(
				$entityfields,
				array_keys($settings->get($schematext.'_columns'))	//all optional
			), array()
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
		
		//get record
	    $params = array(
	    	'property' 	=> $this->_params['property'],
      		'model'		=> $this->_params['model'],
      		'ids'		=> $this->_params['id'],
      		'restricted'=> false,
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
		$record = $commandrtn['data']['entities'][0];

		//update record		
		foreach($filtered as $key => $value)
		{
			$record[$key] = $value;
			if (($this->_params['deepupdate']) && in_array($key, $entityfields))
			{
				$record['Entity'][$key] = $value;
			}			
		}	
		$record->save();	
    	
		//will not revert, just save
    	return $record->toArray();		
	} 	
}
?>
