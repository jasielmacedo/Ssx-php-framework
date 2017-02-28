<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:58:10
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Tickets\templates\tipos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1184957320512dd2a85-78646796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93bb44382528ec8957fb3273ae6b53cb03a08e69' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Tickets\\templates\\tipos.tpl',
      1 => 1421703470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1184957320512dd2a85-78646796',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'edit' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'this_action' => 0,
    'data_error' => 0,
    'fields' => 0,
    'js_content' => 0,
    'pagination' => 0,
    'pagination_page' => 0,
    'all' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57320512e4faa1_10116770',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320512e4faa1_10116770')) {function content_57320512e4faa1_10116770($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class="content">
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</h2>
	<div class='content well'>
		<h4><?php if ($_smarty_tpl->tpl_vars['edit']->value) {
echo $_smarty_tpl->tpl_vars['locale']->value->edit;
} else {
echo $_smarty_tpl->tpl_vars['locale']->value->add;
}?> <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 <?php if ($_smarty_tpl->tpl_vars['edit']->value) {?><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" class="btn btn-small btn-danger">Cancelar Edição</a><?php }?></h4>
		
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
>	
</div>
<div class='content-list'>

	<?php if ($_smarty_tpl->tpl_vars['pagination']->value) {?>
	<div class="pagination">
		   <div class='pages'>
		   	<p class='page_item'>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pagination']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
				<?php if ($_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]!=$_smarty_tpl->tpl_vars['pagination_page']->value) {?>
					<a class='btn btn-small btn-inverse btn-default' href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a>
				<?php } else { ?>
					<a class='btn btn-small disabled btn-default' href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a>
				<?php }?>
			<?php endfor; endif; ?>
			</p>
			<div class="clear"></div>
		  </div>
		  <div class="clear"></div>
	</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->tpl_vars['all']->value) {?>
	<table width="100%" class='table table-striped'>
	<thead>
		<tr>
		    <th>&nbsp;</th>
			<th width="40%">Nome</th>
			<th class='hidden-xs'>Criado em</th>
			<th class='hidden-xs'>Ultima modificação em</th>
			<th width='20%'>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['all']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
		    <td nowrap="nowrap" width="5"><i class="icon-bookmark"></i></td>
			<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['object_name'];?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_created'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_modified'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
</td>
			<td align="right">
			  	<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-info"><?php echo $_smarty_tpl->tpl_vars['locale']->value->edit;?>
</a>
			  	<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
?delete=true" class="btn btn-small btn-warning remove"><?php echo $_smarty_tpl->tpl_vars['locale']->value->delete;?>
</a>
			</td>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
	</table>
	<?php } else { ?>
		<p class='label label-warning'>Nenhum <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 cadastrado</p>
	<?php }?>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
	$(function(){
		$('.remove').click(function(){
			if(confirm("Tem certeza remover esse tipo de chamado? Se houver algum chamado cadastrado com ele, não será possível remover."))
				return true;
			return false;
		});
	});
<?php echo '</script'; ?>
><?php }} ?>
