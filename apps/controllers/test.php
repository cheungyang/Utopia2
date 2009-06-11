<?php

class Test extends Controller {

	function Test()
	{
		parent::Controller();	
	}
	
	function entity()
	{
		$this->load->helper('form');
		$formstr = '';
		$formstr .= form_open('model/tester');
		$formstr .= form_input();
		$formstr .= form_close();

		$smarty = SmartyConnect::getInstance();
		$smarty->assign('DIR_CSS_ROOT', DIR_CSS_ROOT);
		$smarty->assign('form', $formstr);
		$smarty->display('modeltester.tpl');
		//$this->load->view('welcome_message');
	}
}

/* End of file model.php */