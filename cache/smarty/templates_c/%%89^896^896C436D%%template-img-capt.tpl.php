<?php /* Smarty version 2.6.25, created on 2009-06-07 20:29:47
         compiled from template-img-capt.tpl */ ?>
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
  <div class="container">
    
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
      <img src="<?php echo $this->_tpl_vars['WEB_FILES_ROOT']; ?>
img/<?php echo $this->_tpl_vars['page']['3']; ?>
" class="resize"/>
    </div>
    
    <?php if ($this->_tpl_vars['page']['5'] != ""): ?>
    <div class="span-24 last photocaption">
      <p class="para"><?php echo $this->_tpl_vars['page']['5']; ?>
</p>
    </div>
    <?php endif; ?>
    
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