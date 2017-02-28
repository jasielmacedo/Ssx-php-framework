<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:59:32
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxgroups\templates\view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3119357320564044801-91424861%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0f55c5b37e7ce29ed284b78a8f61ac9107d3a48' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxgroups\\templates\\view.tpl',
      1 => 1421516842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3119357320564044801-91424861',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'view' => 0,
    'view_error' => 0,
    'ssxacl' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'ssx_admin_group_id' => 0,
    'users' => 0,
    'this_action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_573205640c56a6_89485005',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_573205640c56a6_89485005')) {function content_573205640c56a6_89485005($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class='content'>
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
: <?php echo $_smarty_tpl->tpl_vars['view']->value['name'];?>
</h2>
	<span class='text-error'><?php echo $_smarty_tpl->tpl_vars['view_error']->value;?>
</span>
	<dl class="dl-horizontal">
		<dt>Nome:</dt>
			<dd><?php echo $_smarty_tpl->tpl_vars['view']->value['name'];?>
</dd>
		<dt>Descrição:</dt>
			<dd><?php if ($_smarty_tpl->tpl_vars['view']->value['description']) {
echo $_smarty_tpl->tpl_vars['view']->value['description'];
} else { ?>---<?php }?></dd>
		<dt>Criado em:</dt>
			<dd><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['view']->value['date_created'],"%d/%m/%Y &agrave;s %H:%Mh");?>
 por <?php echo $_smarty_tpl->tpl_vars['view']->value['created_by_name'];?>
</dd>
		<dt>Ultima alteração em:</dt>
			<dd class='field' style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['view']->value['date_modified'],"%d/%m/%Y &agrave;s %H:%Mh");?>
 por <?php echo $_smarty_tpl->tpl_vars['view']->value['modified_by_name'];?>
</dd>
	</dl>
	<div>
		 	<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
		     <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['view']->value['id'];?>
" class="btn btn-small btn-info action"><i class="icon-pencil"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->edit;?>
</a>
		     <?php if ($_smarty_tpl->tpl_vars['view']->value['id']!=$_smarty_tpl->tpl_vars['ssx_admin_group_id']->value) {?>
		    	 <a href="javascript:void(0);" data-type="status" data-status="<?php echo $_smarty_tpl->tpl_vars['view']->value['status'];?>
" class="btn btn-small btn-warning action"><i class="icon-warning-sign"></i> <?php if ($_smarty_tpl->tpl_vars['view']->value['status']=="1") {?>Desativar<?php } else { ?>Ativar<?php }?> <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</a>
		     	<a href="javascript:void(0);" data-type="delete" class="btn btn-small btn-danger action"><i class="icon-trash"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->delete;?>
</a>
		  	 <?php }?>
		  	<?php }?>
	</div>
	<hr />
	<?php if ($_smarty_tpl->tpl_vars['users']->value) {?>
	<h4>Usuários do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</h4>
	<table width="100%" class='table table-striped'>
	 <thead>
		<tr>
		    <th>&nbsp;</th>
			<th>Nome</th>
			<th>Email</th>
			<th>usu&aacute;rio</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['users']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
		<tr class='item_line'>
		    <td width="5"><i class="icon-user"></i></td>
			<td><?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['email'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['user'];?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==1) {?>Ativo<?php } else { ?>Inativo<?php }?></td>
			<td align="right">
			 <?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['admin']['ssxusers']['view']) {?> 
			  <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
ssxusers/view/<?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-info">ver usu&aacute;rio</a>
			 <?php }?>
			</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
	</table>
	<?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['view']->value['level']=="2") {?>
		<p class='text-error'>Esse <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 não pode ter usuário</p>
		<?php } else { ?>
		<p class='text-error'>Nenhum usuário nesse <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</p>
		<?php }?>
	<?php }?>
</div>
<?php echo '<script'; ?>
 type='text/javascript'>
<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>

	var singular = "<?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
";
	var redirectUrl = "<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['view']->value['id'];?>
";

<?php }?>
<?php echo '</script'; ?>
><?php }} ?>
