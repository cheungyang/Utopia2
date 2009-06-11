<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('random'));

$schema = $settings->get('schema');

//------------------------------------------------------
$models     	= "'".implode("', '",array_keys($schema))."'";
$cults      	= "'ZH', 'EN', 'CH', 'NONE'";
$defaultcult 	= "'NONE'";
$relationships 	= "'OWN', 'REQUEST', 'INVITE', 'CONNECT'";
$defaultrel 	= "'OWN'";
$properties 	= "'MALLOCWORKS', 'WILGRIST'";

$entity = <<<SCHEMA
Entity:
  tableName:    entity
  actAs:
    Timestampable:  ~
    Sluggable:  { fields: [name], name: permlink, unqiue: false, canUpdate: true}
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

Map:
  tableName:    map
  actAs:        [Timestampable]
  options:      { type: InnoDB, collate: utf8_unicode_ci, charset: utf8 }    
  columns:
    src_id:     { type: integer(20), primary: true }    
    tgt_id:     { type: integer(20), primary: true }
    src_model:  { type: enum, values: [$models], notnull: true }
    tgt_model:  { type: enum, values: [$models], notnull: true }
    is_active:  { type: integer(1), default: 1 }
    is_block:   { type: integer(1), default: 0 }
    is_close:   { type: integer(1), default: 0 }
    is_delete:  { type: integer(1), default: 0 }    
  relations:
    Entity:     { local: src_id, foreign: id, foreignAlias: Map }
    Entity:     { local: tgt_id, foreign: id, foreignAlias: Map }
    
Own:
#might need to add permission control later
  tableName:    own
  actAs:        [Timestampable]
  options:      { type: InnoDB, collate: utf8_unicode_ci, charset: utf8 }    
  columns:
    src_id:     { type: integer(20), primary: true }
    tgt_id:     { type: integer(20), primary: true }
    src_model:  { type: enum, values: [$models], notnull: true }
    tgt_model:  { type: enum, values: [$models], notnull: true }
    rel:        { type: enum, values: [$relationships] }, default: $defaultrel, notnull: true }
    is_active:  { type: integer(1), default: 1 }
    is_block:   { type: integer(1), default: 0 }
    is_close:   { type: integer(1), default: 0 }
    is_delete:  { type: integer(1), default: 0 }    
  relations:
    Entity:     { local: src_id, foreign: id, foreignAlias: Own }
    Entity:     { local: tgt_id, foreign: id, foreignAlias: Own }      
SCHEMA;

$entitybase = <<<SCHEMA
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
SCHEMA;

$entityArr = Yaml::load($entity);
$entitybaseArr = Yaml::load($entitybase);
$entitycultArr = Yaml::load("cult: { type: enum, values: [$cults], default: $defaultcult, notnull: true }");
$entityversionArr = Yaml::load("version: { type: integer(11), notnull: true }");
$entityseqArr = Yaml::load("seq: { type: integer(11), notnull: true }");
//------------------------------------------------------

$rtn = $entityArr;
foreach ($schema as $modelname => $spec)
{   
    $one = $entitybaseArr;
	$one['tableName'] 	= strtolower(trim($modelname));
	if (isset($colspec['properties']['actas']))
		$one['actAs'] =  array_merge($one['actAs'], $colspec['properties']['actas']);
    
	foreach($spec['columns'] as $colname => $colspec)
	{
		foreach($colspec as $name => $value)
		{
			switch($name)
			{
				case 'type':		$one['columns'][$colname]['type'] = $value; break;
				case 'required': 	if ($value) $one['columns'][$colname]['notnull'] = true; break;
				case 'default': 	if (!empty($value)) $one['columns'][$colname]['default'] = $value; break;
				case 'values': 		if (!empty($value)) $one['columns'][$colname]['values'] = $value; break;
				default:
			}	
		}
	}
	
	if (isset($spec['properties']['translateable']) && $spec['properties']['translateable'] == true)
		$one['columns'] = array_merge($one['columns'], $entitycultArr);
	if (isset($spec['properties']['chainable']) && $spec['properties']['chainable'] == true)
		$one['columns'] = array_merge($one['columns'], $entityseqArr);
	if (isset($spec['properties']['versionable']) && $spec['properties']['versionable'] == true)
		$one['columns'] = array_merge($one['columns'], $entityversionArr);

	$rtn[ucfirst(strtolower(trim($modelname)))] = $one;
	if (isset($spec['properties']['versionable']) && $spec['properties']['versionable'] == true)
	{
		$one['tableName'] 	= strtolower(trim($modelname)).'_version';
		$rtn[ucfirst(strtolower(trim($modelname.'_version')))] = $one;
	}
}

echo Yaml::dump($rtn);
