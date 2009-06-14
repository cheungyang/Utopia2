<?php /* Smarty version 2.6.25, created on 2009-06-07 19:16:33
         compiled from template-one-column.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'debug', 'template-one-column.tpl', 33, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
   
<html lang="en">
<head>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "lx10th_common.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>   
</head>
<body>

  <div class="container"  style="background: white;">
    
    <div class="span-24 last">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "lx10th_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    </div>  
  
    <div class="span-24 last">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "lx10th_netvigation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>   
    </div>

    <h1><?php echo $this->_tpl_vars['page']['4']; ?>
</h1> 
    
    <div class="span-24 last">
      <div class="para"><?php echo $this->_tpl_vars['page']['6']; ?>
</div>
    </div>

    <div class="span-24 last">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "lx10th_tail.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
    </div>
    
  </div>
</body>
</html>
<?php echo smarty_function_debug(array(), $this);?>
