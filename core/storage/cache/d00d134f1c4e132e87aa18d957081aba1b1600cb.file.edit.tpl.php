<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:59:04
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxgroups\templates\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1373957320548e96545-45385059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd00d134f1c4e132e87aa18d957081aba1b1600cb' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxgroups\\templates\\edit.tpl',
      1 => 1408143546,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1373957320548e96545-45385059',
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
  'unifunc' => 'content_57320548ec5357_25295158',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320548ec5357_25295158')) {function content_57320548ec5357_25295158($_smarty_tpl) {?><div class='content well'>
	<h2><?php if ($_smarty_tpl->tpl_vars['edit']->value) {
echo $_smarty_tpl->tpl_vars['locale']->value->edit;
} else {
echo $_smarty_tpl->tpl_vars['locale']->value->add;
}?></h2>
	<?php if ($_smarty_tpl->tpl_vars['data_error']->value) {?>
		<div class='alert alert-danger'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</div>
	<?php }?>
	<?php echo $_smarty_tpl->tpl_vars['fields']->value;?>

</div>
<?php echo '<script'; ?>
 type='text/javascript'>
	<?php echo $_smarty_tpl->tpl_vars['js_content']->value;?>

<?php echo '</script'; ?>
><?php }} ?>
