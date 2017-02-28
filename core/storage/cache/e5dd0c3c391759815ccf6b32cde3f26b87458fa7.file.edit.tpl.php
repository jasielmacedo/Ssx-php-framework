<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:58:02
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxusers\templates\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:70305732050ad30b45-88017243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5dd0c3c391759815ccf6b32cde3f26b87458fa7' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxusers\\templates\\edit.tpl',
      1 => 1408143241,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '70305732050ad30b45-88017243',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'edit' => 0,
    'locale' => 0,
    'data_error' => 0,
    'fields' => 0,
    'js_content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732050ad5f950_51475281',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732050ad5f950_51475281')) {function content_5732050ad5f950_51475281($_smarty_tpl) {?><div class='content well'>
	<h3><?php if ($_smarty_tpl->tpl_vars['edit']->value) {
echo $_smarty_tpl->tpl_vars['locale']->value->edit;
} else {
echo $_smarty_tpl->tpl_vars['locale']->value->add;
}?></h3>
	<div class='text-error'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</div>
	<?php echo $_smarty_tpl->tpl_vars['fields']->value;?>

</div>
<?php echo '<script'; ?>
 type='text/javascript'>
	<?php echo $_smarty_tpl->tpl_vars['js_content']->value;?>

<?php echo '</script'; ?>
><?php }} ?>
