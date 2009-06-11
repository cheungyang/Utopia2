<?php

$this->benchmark->mark('code_start');
$this->benchmark->mark('code_end');

echo $this->benchmark->elapsed_time('code_start', 'code_end');
echo $this->benchmark->elapsed_time(); //at view, total time
echo $this->benchmark->memory_usage();

//-------------------------------------
//http://codeigniter.com/user_guide/libraries/calendar.html
$this->load->library('calendar');

echo $this->calendar->generate();
echo $this->calendar->generate(2006, 6);

//-------------------------------------
//build my own config, load at application/config/autoload.php
$this->config->site_url();
$this->config->system_url();

//-------------------------------------
//database: import doctrine command class as library

//-------------------------------------
$this->load->library('email');

$this->email->from('your@example.com', 'Your Name');
$this->email->to('someone@example.com');
$this->email->cc('another@another-example.com');
$this->email->bcc('them@their-example.com');

$this->email->subject('Email Test');
$this->email->message('Testing the email class.');
$this->email->set_alt_message('Testing the email class.')
$this->email->attach('filename');
$this->email->send();

$this->email->clear()
echo $this->email->print_debugger();

//-------------------------------------
$config['encryption_key'] = "YOUR KEY";  //@application/config/config.php

$this->load->library('encrypt');
$encrypted_string = $this->encrypt->encode($msg);
$plaintext_string = $this->encrypt->decode($encrypted_string);
$this->encrypt->sha1();

//-------------------------------------
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$config['max_size'] = '100';
$config['max_width'] = '1024';
$config['max_height'] = '768';

$this->load->library('upload', $config);

//-------------------------------------
$this->load->helper(array('form', 'url'));
		
$this->load->library('form_validation');
			
$config = array(
array(
	 'field'   => 'username',
	 'label'   => 'Username',
	 'rules'   => 'required'
  ),
array(
	 'field'   => 'password',
	 'label'   => 'Password',
	 'rules'   => 'required'
  ),
array(
	 'field'   => 'passconf',
	 'label'   => 'Password Confirmation',
	 'rules'   => 'required'
  ),   
array(
	 'field'   => 'email',
	 'label'   => 'Email',
	 'rules'   => 'required'
  )
);
$this->form_validation->set_rules($config); 
		
if ($this->form_validation->run() == FALSE)

//-------------------------------------
