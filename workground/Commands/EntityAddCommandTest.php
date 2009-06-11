<?php
require_once('d:/xampp/htdocs/utopia/libs/main/Config/SettingFactory.php');
$settings = SettingFactory::getSettings(array('env'=>'alpha'));

//$params = array(
//	'property'=>'MALLOCWORKS', 
//	'name'=>'nameA', 
//	'id'=>1, 
//	'newversion'=>true,
//	'newseq'=>true,
//	'newcult'=>true,
//	'inputs'=>array('view'=>'a', 'controller'=>'b', 'cult'=>'ZH')
//);
//$command = CommandFactory::getCommand('page_add', $params);
//$rtn = $command->execute();
//print_r($rtn);

	try
	{
		$params = array(
			'property' => 'MALLOCWORKS',
			'name' => 'AA',
			'inputs' => array(
				'view' => 'A',
				'controller' => 'B',
				'cult' => 'ZH',
				'is_active' => '1',
			),
			'versiondb' => '1',
		);
		$command = CommandFactory::getCommand('page_add', $params);
		$commandrtn = $command->execute();
		print_r($commandrtn);
	}
	catch(Exception $e)
	{
		//***error handling
	}	
	

