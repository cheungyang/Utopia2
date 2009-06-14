<?php /* Smarty version 2.6.25, created on 2009-06-07 19:44:59
         compiled from lx10th_netvigation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'lx10th_netvigation.tpl', 11, false),)), $this); ?>
<ul id="lx10th_netvigation">
  <?php if (isset ( $this->_tpl_vars['prepage'] )): ?>
    <li><a href="<?php echo $this->_tpl_vars['prepage']; ?>
">上一頁</a></li>
  <?php endif; ?>      
  
  <?php $_from = $this->_tpl_vars['allpages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['page']):
?>
    <?php if ($this->_tpl_vars['page']['url'] == $this->_tpl_vars['curpage']): ?>
      <li><a title="<?php echo $this->_tpl_vars['page']['title']; ?>
" href="<?php echo $this->_tpl_vars['page']['url']; ?>
" class="current">&nbsp;</a></li>
    <?php else: ?>
      <?php if ($this->_tpl_vars['page']['thumb'] == ""): ?>
      <li><a title="<?php echo ((is_array($_tmp=$this->_tpl_vars['page']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
" href="<?php echo $this->_tpl_vars['page']['url']; ?>
">&nbsp;</a></li>
      <?php else: ?>
      <li><a title="<table><tr><td><img src='<?php echo $this->_tpl_vars['WEB_FILES_ROOT']; ?>
img/thumbnail/<?php echo $this->_tpl_vars['page']['thumb']; ?>
'/></td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['page']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</td></tr></table>" href="<?php echo $this->_tpl_vars['page']['url']; ?>
">&nbsp;</a></li>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>

  <?php if (isset ( $this->_tpl_vars['nextpage'] )): ?>
    <li><a href="<?php echo $this->_tpl_vars['nextpage']; ?>
">下一頁</a></li>
  <?php endif; ?>  
</ul>

<br/>
<br/>

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['WEB_JS_ROOT']; ?>
vendor/jquery/jquery-tooltip/jquery.tooltip.css" type="text/css" media="screen, projection">
<script src="<?php echo $this->_tpl_vars['WEB_JS_ROOT']; ?>
vendor/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['WEB_JS_ROOT']; ?>
vendor/jquery/jquery-tooltip/lib/jquery.dimensions.js" type="text/javascript"></script>
<script src="<?php echo $this->_tpl_vars['WEB_JS_ROOT']; ?>
vendor/jquery/jquery-tooltip/jquery.tooltip.js" type="text/javascript"></script>

<script type="text/javascript">
<?php echo ' 
$(function() {
  $("#lx10th_netvigation li a").tooltip({ 
    track: true, 
    delay: 0, 
    showURL: false, 
    opacity: 1, 
    fixPNG: true, 
    showBody: " - ", 
    extraClass: "pretty fancy", 
    top: -15, 
    left: 5 
});
});
'; ?>

</script>