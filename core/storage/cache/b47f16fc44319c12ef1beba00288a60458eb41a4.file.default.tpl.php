<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-09 22:25:52
         compiled from "E:\dropbox\Dropbox\ssx\project\themes\default\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:58855730f250caff61-34966261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b47f16fc44319c12ef1beba00288a60458eb41a4' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\themes\\default\\default.tpl',
      1 => 1372115852,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58855730f250caff61-34966261',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'theme_path' => 0,
    'ssx_disable_header' => 0,
    'ssx_content_path' => 0,
    'ssx_disable_footer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5730f250ce2bf7_02108436',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5730f250ce2bf7_02108436')) {function content_5730f250ce2bf7_02108436($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['theme_path']->value&&!$_smarty_tpl->tpl_vars['ssx_disable_header']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['theme_path']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['ssx_content_path']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['ssx_content_path']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['theme_path']->value&&!$_smarty_tpl->tpl_vars['ssx_disable_footer']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['theme_path']->value)."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php }} ?>
