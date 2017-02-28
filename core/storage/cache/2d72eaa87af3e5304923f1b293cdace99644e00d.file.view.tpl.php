<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:57:57
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxusers\templates\view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3640573205059ff223-55073981%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d72eaa87af3e5304923f1b293cdace99644e00d' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxusers\\templates\\view.tpl',
      1 => 1421516878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3640573205059ff223-55073981',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'view' => 0,
    'view_error' => 0,
    'ssxacl' => 0,
    'ssx_guest_id' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'is_your' => 0,
    'ssx_admin_id' => 0,
    'addicional_content' => 0,
    'this_action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57320505a9f4d7_50914799',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320505a9f4d7_50914799')) {function content_57320505a9f4d7_50914799($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class='content'>
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
: <?php echo $_smarty_tpl->tpl_vars['view']->value['name'];?>
</h2>
	<span class='text-error'><?php echo $_smarty_tpl->tpl_vars['view_error']->value;?>
</span>
	<dl class="dl-horizontal">
		<dt>Login</dt>
			<dd><?php echo $_smarty_tpl->tpl_vars['view']->value['user'];?>
</dd>
		<dt>Nome</dt>
			<dd><?php echo $_smarty_tpl->tpl_vars['view']->value['name'];?>
</dd>
		<dt>Email</dt>
			<dd><?php echo $_smarty_tpl->tpl_vars['view']->value['email'];?>
</dd>
		<dt>Criado em</dt>
			<dd><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['view']->value['date_created'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['view']->value['created_by_name'];?>
</dd>
		<dt>Ultima alteração em</dt>
			<dd><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['view']->value['date_modified'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['view']->value['modified_by_name'];?>
</dd>
	</dl>
	
		<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
		<div>
		  	 <?php if ($_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_guest_id']->value) {?>
		     <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['view']->value['id'];?>
" class="btn btn-small btn-success"><i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->edit;?>
</a>
		     <?php }?>
		     <?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['admin']['auth']['change_pass']&&$_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_guest_id']->value&&!$_smarty_tpl->tpl_vars['is_your']->value&&$_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_admin_id']->value) {?>
		      <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
auth/change_pass?id=<?php echo $_smarty_tpl->tpl_vars['view']->value['id'];?>
"  class="btn btn-small btn-info"><i class="icon-lock"></i> Trocar senha</a>
		     <?php }?>
		     <?php if (!$_smarty_tpl->tpl_vars['is_your']->value&&$_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_admin_id']->value&&$_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_guest_id']->value) {?>
		    	 <a href="javascript:void(0);" data-type="status" data-status="<?php echo $_smarty_tpl->tpl_vars['view']->value['status'];?>
" class="btn btn-small btn-warning action"><i class="icon-warning-sign"></i> <?php if ($_smarty_tpl->tpl_vars['view']->value['status']=="1") {?>Desativar<?php } else { ?>Ativar<?php }?> <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</a>
		     	 <a href="javascript:void(0);" data-type="delete" class="btn btn-small btn-danger action"><i class="icon-trash"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->delete;?>
</a>
		  	 <?php }?>
		 </div>
		<?php }?>
	<?php echo $_smarty_tpl->tpl_vars['addicional_content']->value;?>

</div>
<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
<?php echo '<script'; ?>
 type='text/javascript'>

var singular = "<?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
";
var redirectUrl = "<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['view']->value['id'];?>
";

<?php echo '</script'; ?>
>
<?php }?><?php }} ?>
