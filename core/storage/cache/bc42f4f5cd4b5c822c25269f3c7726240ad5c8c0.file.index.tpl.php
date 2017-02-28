<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:59:11
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxproject\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:309005732054f3f5143-72659160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc42f4f5cd4b5c822c25269f3c7726240ad5c8c0' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxproject\\templates\\index.tpl',
      1 => 1419634119,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309005732054f3f5143-72659160',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'data_error' => 0,
    'saved' => 0,
    'fields' => 0,
    'js_content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732054f423f50_17235296',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732054f423f50_17235296')) {function content_5732054f423f50_17235296($_smarty_tpl) {?><div class='content well'>
	<h2> <?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</h2>
	<?php if ($_smarty_tpl->tpl_vars['data_error']->value) {?>
		<div class='alert alert-danger'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['saved']->value) {?>
		<div class='alert alert-success'>Dados alterados com sucesso</div>
		
		<?php echo '<script'; ?>
 type='text/javascript'>
			setTimeout(function(){ 
				$('.success_field').fadeOut(); 
			}, 3000);
		<?php echo '</script'; ?>
>
		
	<?php }?>
	<?php echo $_smarty_tpl->tpl_vars['fields']->value;?>

</div>
<?php echo '<script'; ?>
 type='text/javascript'>
	<?php echo $_smarty_tpl->tpl_vars['js_content']->value;?>

<?php echo '</script'; ?>
><?php }} ?>
