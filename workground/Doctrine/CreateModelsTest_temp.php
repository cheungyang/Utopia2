<?php
require_once('bootstrap.php');

$conn1 = Doctrine_Manager::connection($dbenv['entity']['dsn'], 'entity');
$conn2 = Doctrine_Manager::connection($dbenv['farmA']['dsn'], 'farmA');

$filename = DIR_CONF_ROOT .'doctrine/doctrine.yml';
if (!file_exists($filename))
	die('filename '.$filename.' does not exist.');

Doctrine::dropDatabases();
Doctrine::createDatabases();
Doctrine::generateModelsFromYaml($filename, 'models');
Doctrine::createTablesFromModels('models');
die('done!');