<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha'));
$schema = $settings->get('schema', null, 'db');

$models     	= "'".implode("', '",array_keys($schema))."'";
$cults      	= "'".implode("', '", explode(',',NAME_CULTS))."'";
$defaultcult 	= "'".NAME_DEFAULT_CULT."'";
$relationships 	= "'".implode("', '", explode(',',NAME_RELATIONSHIPS))."'";
$defaultrel 	= "'".NAME_DEFAULT_REL."'";
$properties		= "'".implode("', '", explode(',',NAME_PROPERTIES))."'";

//--------------------------------------------------------
$entityTable = <<<TABLE
tableName:    entity
actAs:
  Timestampable:  ~
  Sluggable:  { fields: [name], name: permlink, unqiue: true, canUpdate: true}
options:      { type: InnoDB, collate: utf8_unicode_ci, charset: utf8 }
columns:
  id:         { type: integer(20), primary: true, autoincrement: true }
  property:   { type: enum, values: [$properties], notnull: true }
  model:      { type: enum, values: [$models], notnull: true }
  name:       { type: string(100), notnull: true }
  is_active:  { type: integer(1), default: 1 }
  is_block:   { type: integer(1), default: 0 }
  is_close:   { type: integer(1), default: 0 }
  is_delete:  { type: integer(1), default: 0 }
relations:
  Maps:   { class: Entity, foreignAlias: Entity, refClass: Map, foreign: tgt_id, local: src_id }
  Owns:   { class: Entity, foreignAlias: Entity, refClass: Own, foreign: tgt_id, local: src_id }
indexes:
  idx_permlink: { fields: [property, model, permlink], type: unique }  
TABLE;
$entityBaseTable = <<<TABLE
actAs:    
  Timestampable:  ~  
options:      { type: InnoDB, collate: utf8_unicode_ci, charset: utf8 }      
columns:
  id:         { type: integer(20), primary: true, autoincrement: true }
  name:       { type: string(100), notnull: true }
  entity_id:  { type: integer(20), notnull: true }  
  is_active:  { type: integer(1), default: 1 }
  is_block:   { type: integer(1), default: 0 }
  is_close:   { type: integer(1), default: 0 }
  is_delete:  { type: integer(1), default: 0 }      
relations:    
  Entity:     { local: entity_id, foreign: id }
indexes:
  entity_idx:  { fields: [entity_id] }
TABLE;
$entityBaseCult = <<<TABLE
cult:       { type: enum, values: [$cults], default: $defaultcult, notnull: true }
TABLE;
$entityBaseVersion = <<<TABLE
version:    { type: integer(11), notnull: true }
TABLE;
$entityBaseSeq = <<<TABLE
seq:        { type: integer(11), notnull: true }
TABLE;

$entityTableArr 	= Horde_Yaml::load($entityTable);
$entityBaseTableArr = Horde_Yaml::load($entityBaseTable);
$entityBaseCultArr 	= Horde_Yaml::load($entityBaseCult);
$entityBaseVersionArr = Horde_Yaml::load($entityBaseVersion);
$entityBaseSeqArr 	= Horde_Yaml::load($entityBaseSeq);
//--------------------------------------------------------
$rtnschema = array();
$rtnschema['ENTITY'] = $entityTableArr;
foreach($schema as $schemaname => $schemaprop)
{
	$cur = array();
	foreach($schemaprop['columns'] as $fieldname => $fieldarr)
	{
		foreach($fieldarr as $key => $value)
		{
			switch($key)
			{
				case 'type': 	$cur['columns'][$fieldname]['type'] = $value; break;
				case 'default': $cur['columns'][$fieldname]['default'] = $value; break;
				case 'required':$cur['columns'][$fieldname]['nonull'] = $value; break;
				case 'values':	$cur['columns'][$fieldname]['values'] = $value; break;
			}
		}
	}
	
	if ($schemaprop['properties']['translateable'])
	{
		$cur['columns']['cult'] = $entityBaseCultArr['cult'];
	}
	
	if ($schemaprop['properties']['chainable'])
	{
		$cur['columns']['seq'] = $entityBaseSeqArr['seq'];
	}
	
	if ($schemaprop['properties']['versionable'])
	{
		$cur['columns']['version'] = $entityBaseVersionArr['version'];
	}
	//echo "<pre>"; print_r($cur); echo "</pre>";
	$rtnschema[$schemaname] = $entityBaseTableArr;
	$rtnschema[$schemaname]['tableName'] = strtolower($schemaname);
	$rtnschema[$schemaname]['columns'] = array_merge($rtnschema[$schemaname]['columns'], $cur['columns']);
	
	if ($schemaprop['properties']['versionable'])
	{
		$rtnschema[$schemaname.'_version'] = $rtnschema[$schemaname];
		$rtnschema[$schemaname.'_version']['tableName'] = strtolower($schemaname.'_version');
	}
}

//echo "<pre>"; print_r($rtnschema); echo "</pre>";
echo Horde_Yaml::dump($rtnschema);








