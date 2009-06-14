<?php
class FormObjectTest extends PhpunitClass
{
    public function testPrintForm()
    {
		$struct = <<<FORM
form1:
  username: 
    label: username
    type: text
    opts: { size: 50, class: inputclass }
    required: true
    info: 'please enter your username'
    filters:
      string: {errmsg: 'username error'}
      trim: ~
  password: 
    label: password
    type: text
    opts: { size: 50, class: inputclass }
    required: true
    info: 'please enter your password'
    filters:
      string: {errmsg: 'password error'}
      trim: ~         
form2:
  username2: 
    label: username
    type: text
    opts: { size: 50, class: inputclass }
    required: true
    info: 'please enter your username'
    filters:
      string: {errmsg: 'username error'}
      trim: ~
  password2: 
    label: password
    type: text
    opts: { size: 50, class: inputclass }
    required: true
    info: 'please enter your password'
    filters:
      string: {errmsg: 'password error'}
      trim: ~             
FORM;

		$params = array('struct'=>$struct, 'defaults'=>array('username'=>'yangkingdom', 'password'=>'donotdisplay'));
		$form = ObjectFactory::getObject('form', $params);
		$formstr = $form->printForm(true);
		$this->assertEquals(true, !empty($formstr));    	
    }
}
?>