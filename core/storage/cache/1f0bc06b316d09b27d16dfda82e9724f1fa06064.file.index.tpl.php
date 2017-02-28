<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:58:23
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxplugins\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93215732051f3d2ea0-28442703%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f0bc06b316d09b27d16dfda82e9724f1fa06064' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxplugins\\templates\\index.tpl',
      1 => 1419636688,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93215732051f3d2ea0-28442703',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'ssxacl' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'pagination' => 0,
    'pagination_page' => 0,
    'this_action' => 0,
    'all' => 0,
    'data_error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732051f492551_80800054',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732051f492551_80800054')) {function content_5732051f492551_80800054($_smarty_tpl) {?><div class="content">
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</h2>
	<br />
	<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['install']) {?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/install" class='btn btn-small btn-success'><i class="icon-pencil"></i> Instalar novo <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</a><br /><br />
	<?php }?>
	Para ativar ou desativar um <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 é necessário que o mesmo tenha o arquivo manifest.xml configurado corretamente
</div>
<div class='content-list'>
	<?php if ($_smarty_tpl->tpl_vars['pagination']->value) {?>
	<div class="pagination">
		   <div class='pages'>
		   	<p>
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
					<a class='btn btn-small' href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a>
				<?php } else { ?>
					<a class='btn btn-small disabled' href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
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
	<p>
		<span class='text-error'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</span>
	</p>
	<table width="100%" class='table table-striped'>
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
			<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['real_name'];?>
</td>
			<td class='hidden-xs'><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['description'];?>
</td>
			<td class='hidden-xs' style='text-align:center;'><?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['active']==1) {?><i class="icon-ok"></i><?php } else { ?><i class="icon-off"></i><?php }?></td>
			<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['install']) {?>
			<td align="right" width="30%">

			  <?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['has_config']&&$_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['active']==1) {?>
			  <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/config/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['reference_name'];?>
" class="btn btn-small btn-info"><i class="icon-tasks"></i> Configurar</a>
			  <?php }?>
			  
			  <?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['active']==1) {?>
			  <a href="javascript:void(0);" data-type="desactive" data-id="<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-warning action"><i class="icon-off"></i> Desativar</a>
			  <?php } else { ?>
			  <a href="javascript:void(0);" data-type="active" data-id="<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-warning action"><i class="icon-ok"></i> Ativar</a>
			  <?php }?>
			  <a href="javascript:void(0);" data-type="remove" data-id="<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-danger action"><i class="icon-trash"></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->delete;?>
</a>
			</td>
			<?php }?>
		</tr>
		<?php endfor; endif; ?>
	</table>
	<?php echo '<script'; ?>
 typ='text/javacript'>
		var singular = "<?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
";
	
	 
		$(function(){
			$('.action').click(function(){
				var type = $(this).attr('data-type');
				var id = $(this).attr('data-id');
				
				switch(type)
				{
					case "active":
						Ssx.confirm(function(){
							location.href = "?active=true&plugin_id="+id;
						},"Tem certeza que deseja reativar esse "+singular+"?");
					break;
					case "desactive":
						Ssx.confirm(function(){
							location.href = "?desactive=true&plugin_id="+id;
						},"Tem certeza que deseja desativar esse "+singular+"?");
					break;
					case "remove":
						Ssx.confirm(function(){
							location.href = "?delete=true&plugin_id="+id;
						},"Tem certeza que deseja remover o {$locale->singular}?");
					break;
				}
			});
		});
	
	<?php echo '</script'; ?>
>
	<?php } else { ?>
	<p class='text-error'>Nenhum <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 instalado</p>
	<?php }?>
</div><?php }} ?>
