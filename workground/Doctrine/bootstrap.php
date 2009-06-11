<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');

$settings = SettingFactory::getSettings(array('random'));
$manager = $settings->getManager();

$dbenv = $settings->get('database_alpha');