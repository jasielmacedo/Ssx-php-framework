<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:58:07
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Tickets\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149255732050f83c386-85947350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '116b38465a988d16a5bb5ec7cca2312396147601' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Tickets\\templates\\index.tpl',
      1 => 1422383022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149255732050f83c386-85947350',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_action' => 0,
    'locale' => 0,
    'ssxacl' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'notypes' => 0,
    'pagination' => 0,
    'pagination_page' => 0,
    'all' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732050f8efea3_99485660',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732050f8efea3_99485660')) {function content_5732050f8efea3_99485660($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class="content">
	<h2><?php if ($_smarty_tpl->tpl_vars['this_action']->value=="my") {?>Meus<?php }?> <?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</h2>
	<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['add']) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/add" class='btn btn-success margin_b_10'><i class="icon-plus"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->add;?>
</a>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['notypes']->value) {?>
	<div class="alert alert-warning"><?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['tipos']) {?>É necessário criar tipos de chamados para abrir chamados.<?php } else { ?>Não há tipos de chamados disponíveis para serem abertos.<?php }?></div>
	<?php }?>
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
		    <th>Numero</th>
			<th width='30%'>Título do chamado</th>
			<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['tipos']) {?>
			<th class='hidden-xs' width='10%'>Prioridate</th>
			<?php }?>
			<th class='hidden-xs'>Categoria</th>
			<th class='hidden-xs'>Enviado por</th>
			<th class='hidden-xs'>última mensagem</th>
			<th class='hidden-xs'>Status</th>
			<th width='10%'>&nbsp;</th>
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
		<tr class='item_line' <?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==3) {?>style='color:#dddddd'<?php }?>>
		    <td nowrap="nowrap" width="5"><i class="icon-info-sign"></i></td>
		    <td>#<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'];?>
</td>
			<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['tipos']) {?>
			<td class='hidden-xs'><?php $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['key']->step = 1;$_smarty_tpl->tpl_vars['key']->total = (int) ceil(($_smarty_tpl->tpl_vars['key']->step > 0 ? $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['priority']+1 - (1) : 1-($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['priority'])+1)/abs($_smarty_tpl->tpl_vars['key']->step));
if ($_smarty_tpl->tpl_vars['key']->total > 0) {
for ($_smarty_tpl->tpl_vars['key']->value = 1, $_smarty_tpl->tpl_vars['key']->iteration = 1;$_smarty_tpl->tpl_vars['key']->iteration <= $_smarty_tpl->tpl_vars['key']->total;$_smarty_tpl->tpl_vars['key']->value += $_smarty_tpl->tpl_vars['key']->step, $_smarty_tpl->tpl_vars['key']->iteration++) {
$_smarty_tpl->tpl_vars['key']->first = $_smarty_tpl->tpl_vars['key']->iteration == 1;$_smarty_tpl->tpl_vars['key']->last = $_smarty_tpl->tpl_vars['key']->iteration == $_smarty_tpl->tpl_vars['key']->total;?><i class="icon-star"></i><?php }} ?></td>
			<?php }?>
			<td class='hidden-xs'><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['type'];?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_created'],"%d/%m/%Y - %H:%M");?>
</td>
			<td class='hidden-xs' style='font-size:11px'><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['last_reply']['by'];?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['last_reply']['date'],"%d/%m/%Y - %H:%M");?>
</td>
			<td class='hidden-xs'><?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==1) {?>Aguardando<?php } elseif ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==2) {?>Em andamento<?php } else { ?>Resolvido<?php }?></td>
			<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['view']) {?>
			<td align="right">
			  	<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/view/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-info" title="Ver Chamado"><i class="icon-eye-open icon-white"></i></a>
			</td>
			<?php }?>
		</tr>
		<?php endfor; endif; ?>
	</tbody>
	</table>
	<?php } else { ?>
	<p class='label label-warning'>Nenhum <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 cadastrado</p>
	<?php }?>
</div><?php }} ?>
