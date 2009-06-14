<?php /* Smarty version 2.6.25, created on 2009-06-01 17:31:45
         compiled from modeltester.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Blueprint Forms Tests</title>

  <!-- Framework CSS -->
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/print.css" type="text/css" media="print">
  <!--[if lt IE 8]><link rel="stylesheet" href="<?php echo $this->_tpl_vars['DIR_CSS_ROOT']; ?>
vendor/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

</head>
<body>

	<div class="container showgrid">
		<h1>Model Tester</h1>
		<hr>    
    	<div class="span-24">
    	<?php echo $this->_tpl_vars['form']; ?>

    	</div>    	
	</div>
</body>
</html>