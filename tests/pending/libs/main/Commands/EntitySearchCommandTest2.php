<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha'));

$params = array('property'=>'MALLOCWORKS', 'permlinks'=>'name-a-29');
$command = CommandFactory::getCommand('page_search', $params);
$rtn = $command->execute();
print_r($rtn);