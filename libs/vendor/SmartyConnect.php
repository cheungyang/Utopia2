<?php

// load Smarty library
require('Smarty/Smarty.class.php');

class SmartyConnect extends Smarty 
{

	static private $instance = null;
	
	static public function getInstance()
	{
		if (is_null(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}
	
	private function __construct()
	{
        // Class Constructor. 
        // These automatically get set with each new instance.

		$this->Smarty();

		$this->template_dir = DIR_APP_ROOT.'templates';
		$this->config_dir 	= DIR_CACHE_ROOT.'smarty/config';
		$this->compile_dir	= DIR_CACHE_ROOT.'smarty/templates_c';
		$this->cache_dir 	= DIR_CACHE_ROOT.'smarty/cache';

	}
}
?>
