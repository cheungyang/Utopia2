<?php
class EntityFetchCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_fetch';
	
	protected function doCommand()
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();
		$schematext = 'schema_'.$this->_params['model'];		
		$isEntity = strtolower($this->_params['model']) == 'entity'? true: false;
						
		//select from (should be required)
	    if ($isEntity)
	    {
	      	$q = Doctrine_Query::create()->from("Entity e");       
	    }
	    else
	    {
	    	$modelname = $settings->get($schematext.'_properties_versionable', false) && $this->_params['versiondb']?
				ucfirst(strtolower($this->_params['model'])).'_version':    
				ucfirst(strtolower($this->_params['model']));
	    	    
			$q = Doctrine_Query::create()
	        	->from("$modelname m")
	        	->leftJoin('m.Entity e');       
	    }
	  
	    //property(should be required)
		if (!empty($this->_params['property']))
			$q->andWhere('e.property=?', $this->_params['property']);
			
	    //id (should be required)
	    if (!empty($this->_params['ids']) && !is_array($this->_params['ids']))
		{ 
      		$q->andWhere('e.id=?', $this->_params['ids']);
	    }
	    elseif (!empty($this->_params['ids']) && is_array($this->_params['ids']))
	    {
			$q->andWhereIn('e.id', $this->_params['ids']);
	    }
	
		if ($settings->get($schematext.'_properties_translateable', false) && !empty($this->_params['cult']) && !$isEntity)
		{ 
			$q->andWhere('m.cult=?', $this->_params['cult']);
		}
		
		if ($settings->get($schematext.'_properties_chainable', false) && !empty($this->_params['seq']) && !$isEntity)
		{
			$q->andWhere('m.cult=?', $this->_params['seq']);
		}
		
		if ($settings->get($schematext.'_properties_versionable', false) && !empty($this->_params['version']) && !$isEntity)
		{
			$q->andWhere('m.version=?', $this->_params['version']);
		}
			    
	    if (!empty($this->_params['restricted']) && $this->_params['restricted'] )
	    {
	    	if ($isEntity)
	    	{
	    		$q->andWhere('e.is_delete = 0');
	    	}
	    	else
	    	{
        		$q->andWhere('e.is_delete = 0 AND m.is_delete = 0');
	    	}
	    }      

		$query 	= $q->getSql();
	    $rtn 	= $q->execute();
	    $count 	= count($rtn);
	    return array(
	    	'query' => $query, 
	    	'total' => $count, 
	    	'count' => $count,
	    	'entities'	=> $rtn
	    );
	} 	
}
?>


       
