<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:58:20
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxpages\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:49155732051c0b5534-92941492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99aaa7b4d37ba8d1e41cff051c3157d1b5c7fb49' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxpages\\templates\\index.tpl',
      1 => 1417470376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49155732051c0b5534-92941492',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'allow_error' => 0,
    'ssxacl' => 0,
    'locale' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'group_deleted' => 0,
    'search_query' => 0,
    'pagination' => 0,
    'pagination_page' => 0,
    'this_action' => 0,
    'all' => 0,
    'projecturl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732051c145dd1_31352415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732051c145dd1_31352415')) {function content_5732051c145dd1_31352415($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class="row>
	<div class="content">
		<?php if ($_smarty_tpl->tpl_vars['allow_error']->value&&$_smarty_tpl->tpl_vars['ssxacl']->value['admin']['ssxproject']['index']) {?>
			<div class="alert alert-danger">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <h4>Aviso!</h4>
			  A exibição de páginas para <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 está desabilitada. Entre em <a href='<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
ssxproject'>Configurações do Site</a> e ative.
			</div>
		<?php }?>
		<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->plural;?>
</h2>
		<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/edit" class='btn btn-success margin_b_10'><i class='icon-plus'></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->add;?>
</a>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['group_deleted']->value) {?>
		<div id='popup' class='alert alert-success'><?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 deletado com sucesso</div>
		<?php echo '<script'; ?>
 type='text/javascript'>
			setTimeout(function(){ $('#popup').fadeOut(); }, 3000);
		<?php echo '</script'; ?>
>
		<?php }?>	
	</div>
	<div class='content-list'>
		<div class="w_300 right">
			<form action="" method="get">
				<div class="input-group right">			  
				  <input type="text" class="form-control" name="s" value="<?php echo $_smarty_tpl->tpl_vars['search_query']->value;?>
" placeholder="<?php echo $_smarty_tpl->tpl_vars['locale']->value->search;?>
 por nome do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
">
				  <span class="input-group-btn">
			         <input class="btn btn-default" type="submit" value="<?php echo $_smarty_tpl->tpl_vars['locale']->value->search;?>
">
			      </span>
				</div>
			</form>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['search_query']->value) {?>
		<h4><?php echo $_smarty_tpl->tpl_vars['locale']->value->search;?>
 por: <?php echo $_smarty_tpl->tpl_vars['search_query']->value;?>
</h4>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['pagination']->value) {?>
		<div class="pagination">
			   <div class='pages'>
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
					<div class='page_item'>
					<?php if ($_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]!=$_smarty_tpl->tpl_vars['pagination_page']->value) {?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
?page=<?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];
if ($_smarty_tpl->tpl_vars['search_query']->value) {?>&s=<?php echo $_smarty_tpl->tpl_vars['search_query']->value;
}?>"><?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
</a>
					<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['pagination']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>

					<?php }?>
					</div>
				<?php endfor; endif; ?>
				<div class="clear"></div>
			  </div>
			  <div class="clear"></div>
		</div>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['all']->value) {?>
		<table width="100%" class='table table-striped clear'>
		<thead>
			<tr>
			    <th>&nbsp;</th>
				<th>Título</th>
				<th>Url</th>
				<th>Criado em:</th>
				<th>Ultima modificação em:</th>
				<th>Status</th>
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
			    <td width="5"><i class='icon-tag'></i></td>
				<td><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'];?>
</td>
				<td width='25%'><?php echo $_smarty_tpl->tpl_vars['projecturl']->value;?>
<strong><?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['slug'];?>
</strong></td>
				<td style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_created'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
</td>
				<td style='font-size:11px'><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['date_modified'],"%d/%m/%Y - %H:%M");?>
 por <?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['created_by_name'];?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==1) {?>Publicada<?php } else { ?>Desativa<?php }?></td>
				<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['view']) {?>
				<td align="right">
					<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['edit']) {?>
					<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/edit/<?php echo $_smarty_tpl->tpl_vars['all']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="btn btn-small btn-success"><i class='icon-pencil'></i> <?php echo $_smarty_tpl->tpl_vars['locale']->value->edit;?>
</a>
					<?php }?>
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
		<hr />
		<p class='text-error'>Nenhum <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
 <?php if ($_smarty_tpl->tpl_vars['search_query']->value) {?>encontrado para <strong><?php echo $_smarty_tpl->tpl_vars['search_query']->value;?>
</strong><?php } else { ?>cadastrado<?php }?></p>
		<?php }?>
	</div>
</div><?php }} ?>
