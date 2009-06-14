<?php /* Smarty version 2.6.25, created on 2009-06-03 17:44:58
         compiled from template-one-column.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'debug', 'template-one-column.tpl', 32, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
   
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Blueprint Forms Tests</title>

  <!-- Framework CSS -->
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['WEB_CSS_ROOT']; ?>
vendor/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['WEB_CSS_ROOT']; ?>
vendor/blueprint/print.css" type="text/css" media="print">
  <!--[if lt IE 8]><link rel="stylesheet" href="<?php echo $this->_tpl_vars['WEB_CSS_ROOT']; ?>
vendor/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

</head>
<body>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "lx10th_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 

<?php if (isset ( $this->_tpl_vars['nextpage'] )): ?><a href="<?php echo $this->_tpl_vars['nextpage']; ?>
">Next</a><?php endif; ?>
<?php if (isset ( $this->_tpl_vars['prepage'] )): ?><a href="<?php echo $this->_tpl_vars['prepage']; ?>
">Previous</a><?php endif; ?>

	<div class="container showgrid">
		<h1><?php echo $this->_tpl_vars['page']['4']; ?>
</h1>

    <div class="span-24">
    <?php echo $this->_tpl_vars['page']['6']; ?>

    </div>
  </div>

</body>
</html>
<?php echo smarty_function_debug(array(), $this);?>
