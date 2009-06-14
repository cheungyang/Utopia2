<?php

class EntityAddCommandTest extends PhpunitClass
{
    public function testNormalAdd()
    {
		$params = array(
			'name' => 'AA',
			'inputs' => array(
				'view' => 'A',
				'controller' => 'B',
				'cult' => 'ZH',
				'is_active' => '1',
			),
		);
			
		$command = CommandFactory::getCommand('page_add', $params);
		$commandrtn = $command->execute();
		//pc($commandrtn);
		$this->assertEquals(SUCCESS, $commandrtn['status']);    
    }
}