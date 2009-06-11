<?php
require_once('bootstrap.php');

$conn1 = Doctrine_Manager::connection($dbenv['entity']['dsn'], 'entity');

$entity = new Entity();
$entity['name'] = 'jwage';
$entity->save();
?>