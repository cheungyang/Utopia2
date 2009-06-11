<?php
require_once('bootstrap.php');

$conn1 = Doctrine_Manager::connection($dbenv['entity']['dsn'], 'entity');
$conn2 = Doctrine_Manager::connection($dbenv['farmA']['dsn'], 'farmA');

$manager->createDatabases();
//$manager->dropDatabases();

foreach($manager as $conn) {
    echo $conn->getName();
    $manager->closeConnection($conn);
} 