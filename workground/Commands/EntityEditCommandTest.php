<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha'));

$params = array(
	'property'=>'MALLOCWORKS',
	'id' => '37', 
	'inputs'=>array('is_active'=> 0, 'name'=>'NNN', 'view'=>'AAA', 'controller'=>'BBB', 'cult'=>'zh'), 
	'deepupdate'=>true);
$command = CommandFactory::getCommand('page_edit', $params);
$rtn = $command->execute();
print_r($rtn);