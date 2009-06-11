<?php
class EntitySearchCommand extends BaseCommand implements ICommand
{
	protected $_name = 'entity_search';
	
	protected function doCommand()
	{
		$settings = SettingFactory::getSettings();
		$settings->getConnection();
		$schematext = 'schema_'.$this->_params['model'];
		$isEntity = strtolower($this->_params['model']) == 'entity'? true: false;
						
		//select from 
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
			
	    //if permlinks are set, sort by permlinks
	    if (!empty($this->_params['permlinks']) && !is_array($this->_params['permlinks']))
		{ 
			$q->andWhere('e.permlink=?', $this->_params['permlinks']);
	    }
	    elseif (!empty($this->_params['permlinks']) && is_array($this->_params['permlinks']))
	    {
			$q->andWhereIn('e.permlink', $this->_params['permlinks']);
	    }
	    
	    //lossely defined where cause
		if (!empty($this->_params['where']))
		{
			foreach ($this->_params['where'] as $onekey => $onewhere)
			{
				$q->andWhere($onekey, $onewhere);
			}
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
		      
		if (!empty($this->_params['sort']))
	    {
			$q->orderBy($this->_params['sort']);
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
	
	    //get count before limt   
	    $total = $q->count();  
	      
		if (!empty($this->_params['offset']))
	    {
			$q->offset($this->_params['offset']);
	    }

		if (!empty($this->_params['limit']))
	    {
			$q->limit($this->_params['limit']);
	    }	    

		$query 	= $q->getSql();
	    $rtn 	= $q->execute();
	    $count 	= count($rtn);
	    return array(
	    	'query' => $query, 
	    	'total' => $total, 
	    	'count' => $count,
	    	'entities'	=> $rtn
	    );
	} 	
}
?>


       
