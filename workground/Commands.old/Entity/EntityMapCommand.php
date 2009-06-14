<?php
class EntityMapCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_map';
	
	protected function doCommand()
	{	
		$settings = SettingFactory::getSettings();
		$settings->getConnection();		
		$schematext = 'schema_'.$this->_params['model'];
		
		//validation
		$spec = array(
			'is_active' => array('default'=>'1'),
			'is_block' 	=> array('default'=>'0'),
			'is_close'  => array('default'=>'0'),
			'is_delete' => array('default'=>'0'),
		); 
		$validator = ValidatorFactory::getValidator($this->_params['flags'], $spec);
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
		
		//create mapping
		if (strtoupper($this->_params['relationship']) == 'MAP')
		{
			$map = new Map();
		}
		else
		{
			$map = new Own();
		}
		$map['src_id'] = $this->_params['id'];
		$map['tgt_id'] = $this->_params['tgtid'];
		$map['src_model'] = strtoupper($this->_params['model']);
		$map['tgt_model'] = strtoupper($this->_params['tgtmodel']);
		foreach ($filtered as $paramkey => $paramval)
    	{
			$map[$paramkey] = $paramval;
    	}
    	$map->save();

    	return $map->toArray(true);
	} 	
}
?>
