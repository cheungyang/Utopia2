<?php
echo <<<ECHO
---------------------------------------
+  
+    $argv[0]
+
---------------------------------------\n
ECHO;
if ($argc != 2)
{
	echo "syntax: php {$argv[0]} [property]\n";
	die();
}

$property = strtoupper($argv[1]);
require_once('../libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha', 'property'=>$property));

//------------------------------------------------------
$schema = array_merge($settings->get('schema_BASE'), $settings->get('schema_'.$property));
//pr($schema);
$models     	= "'".implode("', '",array_keys($schema))."'";
$cults      	= NAME_CULTS;
$defaultcult 	= NAME_DEFAULT_CULT;
$relationships 	= NAME_RELATIONSHIPS;
$defaultrel 	= NAME_DEFAULT_REL;
$properties 	= NAME_PROPERTIES;

//------------------------------------------------------
$entity = <<<SCHEMA
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
    rel:        { type: enum, values: [$relationships], default: $defaultrel, notnull: true }
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
	$one = array();   
	$one['tableName'] 	= strtolower(trim($modelname));

	if (isset($spec['properties']['actas']))
	{
		$one['actAs'] =  isset($one['actAs'])? array_merge($one['actAs'], $spec['properties']['actas']): $spec['properties']['actas'];
	}
	
	foreach($spec['columns'] as $colname => $colspec)
	{
		foreach($colspec as $name => $value)
		{		
			switch($name)
			{
				case 'type':		$one['columns'][$colname]['type'] = $value; break;
				case 'required': 	if ($value) $one['columns'][$colname]['notnull'] = true; break;
				case 'default': 	if (!empty($value)) $one['columns'][$colname]['default'] = $value; break;
				case 'values':		if (!empty($value)) $one['columns'][$colname]['values'] = $value; break;
				case 'primary': 	if (!empty($value)) $one['columns'][$colname]['primary'] = $value; break;
				case 'autoincrement': if (!empty($value)) $one['columns'][$colname]['autoincrement'] = $value; break;
				default:
			}	
		}
	}
	
	if (strcasecmp($modelname,'ENTITY') == 0) //special treatment for entity table
	{
		$one['columns']['property']['values'] = explode(',',$properties);
		$one['columns']['model']['values'] = array_keys($schema);
		$one['relations'] = isset($one['relations'])? array_merge($one['relations'], $spec['relations']): $spec['relations'];
		$one['indexes'] = isset($one['indexes'])? array_merge($one['indexes'], $spec['indexes']): $spec['indexes'];
		$rtn[ucfirst(strtolower(trim($modelname)))] = $one;	
	}
	else //for all other models
	{	
		$one = array_merge($entitybaseArr, $one);
		
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
}

//------------------------------------------------------
//write as configuration file

$writedir = DIR_CONF_ROOT .'doctrine/';
$writefile = $writedir.strtolower($property).'.yml';
if (!is_dir($writedir))
{
	echo 'creating directory '.$writedir.'...';
	echo mkdir($writedir, 0755, true) === TRUE? "[OK]\n": "[FAILED]\n";
}

echo 'writing yml to '.$writefile.'...';
echo file_put_contents($writefile, Yaml::dump($rtn), LOCK_EX) !== FALSE? "[OK]\n": "[FAILED]\n";


