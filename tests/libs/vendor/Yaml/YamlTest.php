<?php

class YamlTest extends PhpunitClass
{
    public function testLoadArray()
    {
		$str = <<<FFF
USER:
  properties:	{ translateable: false, chainable: false, versionable: true }
  columns:
    username:   { type: string(50), required: true, validators: [], default: ~, values: ~ }
    password:   { type: string(64), required: true, validators: [], default: ~, values: ~ }
    email:      { type: string(50), required: true, validators: [], default: ~, values: ~ }
FFF;
    
		$array = Yaml::load($str);
		$this->assertArrayHasKey('USER', $array);    	
    }
}
?>