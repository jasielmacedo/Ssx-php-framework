<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:41:54
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxusers\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1673757320142324d08-00835879%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04d4048f01c2abdec6da765a032277ffaf86079d' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxusers\\templates\\index.tpl',
      1 => 1421343104,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1673757320142324d08-00835879',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'ssxacl' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'user_deleted' => 0,
    'this_action' => 0,
    'groups' => 0,
    'group_selected' => 0,
    'search_query' => 0,
    'pagination' => 0,
    'pagination_page' => 0,
    'all' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57320142407648_05205619',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320142407648_05205619')) {function content_57320142407648_05205619($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class="content">
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</h2>
	<div>
		<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/edit" class='btn btn-success margin_b_10'><i class="icon-plus icon-white"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->add;?>
</a>
		<?php }?>
	</div>
	
	<?php if ($_smarty_tpl->tpl_vars['user_deleted']->value) {?>
		<div id='popup' class='alert alert-success clear'>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 deletado com sucesso
		</div>
	<?php }?>	
</div>
<div class='content-list table-responsive clear'>
	 <div class="right margin_b_10">
			<form action="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" method="get" class="form-inline">
				<div class="form-group">
				    <p class="form-control-static"><label class="label label-default">Buscar por:</label> </p>
				 </div>
				 <div class="form-group">
					<div class="input-group margin_r_10 w_300">
						<span class="input-group-addon">Grupos</span>
						<select class="form-control w_200" name="user_group">
							<option value="">Todos os grupos</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['groups']->value,'selected'=>$_smarty_tpl->tpl_vars['group_selected']->value),$_smarty_tpl);?>

						</select>
					</div>
				</div>	
				<div class="form-group">
					<div class="input-group w_300">		
					  <?php if ($_smarty_tpl->tpl_vars['search_query']->value) {?><span class="input-group-btn"><a title='Limpar Busca' class='btn' href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
"><i class='icon-remove'></i></a></span><?php }?>
					  <input type="text" class="form-control" name="s" value="<?php echo $_smarty_tpl->tpl_vars['search_query']->value;?>
" placeholder="nome do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
" maxlength="255">
					  <span class="input-group-btn">
				         <input class="btn btn-default" type="submit" value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->search;?>
">
				      </span>
					</div>
				</div>
							
			</form>
		</div>
	<?php if ($_smarty_tpl->tpl_vars['search_query']->value) {?>
		<h4><?php echo $_smarty_tpl->tpl_vars['locale']->value->search;?>
 por: <?php echo $_smarty_tpl->tpl_vars['search_query']->value;?>
</h4>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['pagination']->value) {?>
	<ul class="pagination">
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
					<li><a class='btn btn-small btn-inverse' href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];
if ($_smarty_tpl->tpl_vars['search_query']->value) {?>&s=<?php echo $_smarty_tpl->tpl_vars['search_query']->value;
}?>"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a></li>
				<?php } else { ?>
					<li class='active'><a class='btn btn-small disabled' href='javascript:void(0);'><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a></li>
				<?php }?>				
			<?php endfor; endif; ?>
	</ul>
	<div class="clear"></div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['all']->value) {?>
	<table width="100%" class='table table-striped clear'>
	<thead>
		<tr>
		    <th>&nbsp;</th>
			<th>Nome</th>
			<th>Email</th>
			<th class='hidden-xs'>usu&aacute;rio</th>
			<th class='hidden-xs'>Criado em</th>
			<th class='hidden-xs'>Ultima modificação em</th>
			<th class='hidden-xs'>Status</th>
			<th width="15%">&nbsp;</th>
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
		    <td width="5"><i class="icon-user"></i></td>
			<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['email'];?>
</td>
			<td class='hidden-xs'><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['user'];?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_created'],"%d/%m/%Y &agrave;s %H:%Mh");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_modified'],"%d/%m/%Y &agrave;s %H:%Mh");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['modified_by_name'];?>
</td>
			<td class='hidden-xs'><?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==1) {?>Ativo<?php } else { ?>Inativo<?php }?></td>
			<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['view']) {?>
			<td align="right">
			  <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/view/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-info"><?php echo $_smarty_tpl->tpl_vars['locale']->value->view;?>
</a>
			</td>
			<?php }?>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
	</table>
	<?php } else { ?>
	<p class='text-error'>Nenhum <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 cadastrado</p>
	<?php }?>
</div><?php }} ?>
