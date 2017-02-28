<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-11 22:54:03
         compiled from "E:\dropbox\Dropbox\dontmissone.com\project\admin\themes\default\default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1576057339beb757d39-03681040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b66921772812097a38cd6b1c24fccd31a79c0cc1' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\dontmissone.com\\project\\admin\\themes\\default\\default.tpl',
      1 => 1343253558,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1576057339beb757d39-03681040',
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
  'unifunc' => 'content_57339beb786b42_36892795',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57339beb786b42_36892795')) {function content_57339beb786b42_36892795($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['theme_path']->value&&!$_smarty_tpl->tpl_vars['ssx_disable_header']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['theme_path']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['ssx_content_path']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['ssx_content_path']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['theme_path']->value&&!$_smarty_tpl->tpl_vars['ssx_disable_footer']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['theme_path']->value)."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?><?php }} ?>
