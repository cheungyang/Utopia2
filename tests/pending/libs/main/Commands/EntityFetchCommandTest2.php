<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha'));

$params = array('property'=>'MALLOCWORKS', 'ids'=>'1');
$command = CommandFactory::getCommand('page_fetch', $params);
$rtn = $command->execute();
print_r($rtn);