<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:59:06
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxacl\templates\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:306255732054a280d94-21876845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a71e10f4a8c4b8539df9296ac1bc12e766b8888' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxacl\\templates\\edit.tpl',
      1 => 1422382427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '306255732054a280d94-21876845',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'locale' => 0,
    'saved' => 0,
    'data_error' => 0,
    'groups' => 0,
    'group_id' => 0,
    'group' => 0,
    'group_permissions' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'this_action' => 0,
    'p_details' => 0,
    'field_secure' => 0,
    'locals' => 0,
    'itens' => 0,
    'actions' => 0,
    'action' => 0,
    'rule' => 0,
    'ssxacl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732054a36f247_10075915',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732054a36f247_10075915')) {function content_5732054a36f247_10075915($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\dropbox\\Dropbox\\ssx\\core\\resources\\smarty\\libs\\plugins\\modifier.date_format.php';
?><div class='content'>
	<h2><?php echo $_smarty_tpl->tpl_vars['locale']->value->edit;?>
</h2>
	<?php if ($_smarty_tpl->tpl_vars['saved']->value) {?>
		<div class="alert alert-success">
			Dados Alterados com sucesso
		</div>
	<?php }?>
	<div class='error_field'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</div>
	<div class='content_group'>
		<form action="" method="post" id="filter_submit">
			<strong>Grupo:</strong>
			<select name="group_id" class="form-control inline w_250 margin_b_10" onchange="this.form.submit()">
				<option value="">-- Selecione</option>
				<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
				<option <?php if ($_smarty_tpl->tpl_vars['group_id']->value==$_smarty_tpl->tpl_vars['group']->value['id']) {?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['group']->value['name']=="guest") {?>Visitante<?php } else {
echo $_smarty_tpl->tpl_vars['group']->value['name'];
}?></option>
				<?php } ?>
			</select>
			<!-- <br />
			<input type='submit' class='btn btn-inverse' value='Editar permissões' /> -->
		</form>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['group_permissions']->value&&$_smarty_tpl->tpl_vars['group_permissions']->value!="all_access") {?>
		<form action="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" method="post">
			<div class="row">
				<div class="col-sm-12 margin_b_20">
					<div class="col-sm-10">
						Ultima alteração em:
						<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['p_details']->value['date_modified'],"%d/%m/%Y &agrave;s %H:%Mh");?>

					</div>
					<div class="col-sm-2">
						<input type='hidden' name='group_id' value='<?php echo $_smarty_tpl->tpl_vars['group_id']->value;?>
' />
						<?php echo $_smarty_tpl->tpl_vars['field_secure']->value;?>

						<input type="submit" class='btn btn-primary' value="Salvar alterações" name="save" />
					</div>
				</div>
				<div class="col-sm-8">
					 <div class="panel panel-info">                    
		                    <div class="panel-heading bold">Permissões de Acesso</div>
		                    <div class="panel-body">
		                    	<p>
		                    		<span class="f10">Permissões de acesso definem quais páginas o grupo de usuário selecionado poderá acessar no site. Caso uma nova página surgir automaticamente o usuário não terá permissão de acesso.</span>
		                    	</p>
								<?php  $_smarty_tpl->tpl_vars['locals'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['locals']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group_permissions']->value['access']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['locals']->key => $_smarty_tpl->tpl_vars['locals']->value) {
$_smarty_tpl->tpl_vars['locals']->_loop = true;
?>
								   <div class="callout callout-success">
								   		<h4><?php if ($_smarty_tpl->tpl_vars['locals']->key=="admin") {?>Área administrativa<?php } else { ?>Acesso ao site<?php }?></h4>
								   		
								   		<p>Permitir acesso <input type="checkbox" name="data[<?php echo $_smarty_tpl->tpl_vars['locals']->key;?>
][_access]" <?php if ($_smarty_tpl->tpl_vars['locals']->value['_access']) {?> checked="checked"<?php }?> value="A" /></p>
								   		<?php  $_smarty_tpl->tpl_vars['itens'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itens']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['locals']->value['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itens']->key => $_smarty_tpl->tpl_vars['itens']->value) {
$_smarty_tpl->tpl_vars['itens']->_loop = true;
?>
								   		
								   		<div class="margin_t_20">
								   			<span><strong><?php echo $_smarty_tpl->tpl_vars['itens']->key;?>
</strong></span>
								   			<?php  $_smarty_tpl->tpl_vars['actions'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['actions']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itens']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['actions']->key => $_smarty_tpl->tpl_vars['actions']->value) {
$_smarty_tpl->tpl_vars['actions']->_loop = true;
?>
								   				<?php  $_smarty_tpl->tpl_vars['action'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['action']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['actions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['action']->key => $_smarty_tpl->tpl_vars['action']->value) {
$_smarty_tpl->tpl_vars['action']->_loop = true;
?>
										   			<div class="row">
										   				<div class="col-sm-6">&raquo; <?php echo $_smarty_tpl->tpl_vars['action']->key;?>
</div>
										   				<div class="col-sm-6 align_right"><input type='checkbox' name='data[<?php echo $_smarty_tpl->tpl_vars['locals']->key;?>
][modules][<?php echo $_smarty_tpl->tpl_vars['itens']->key;?>
][actions][<?php echo $_smarty_tpl->tpl_vars['action']->key;?>
]' <?php if ($_smarty_tpl->tpl_vars['action']->value) {?>checked="checked"<?php }?> value='A' /> &nbsp; Permitir Acesso</div>
										   			</div>
										   		<?php } ?>
										   	<?php } ?>
								   		</div>
								   		
								   		<?php } ?>
								   </div>
								<?php } ?>
		                    </div>
			         </div>
				</div>
				<div class="col-sm-4">
					 <div class="panel panel-default">                    
		                    <div class="panel-heading bold">Regras de Uso</div>
		                    <div class="panel-body">
		                    	
		                    	<span class="f10">Regras de Uso são usadas pela área de programação do site. Caso não saiba como usa-las entre em contato com o administrador</span>
		                    	<?php if ($_smarty_tpl->tpl_vars['group_permissions']->value['rules']) {?>
		                    	<div class="row margin_t_10 margin_b_10">
		                    		<?php  $_smarty_tpl->tpl_vars['rule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group_permissions']->value['rules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rule']->key => $_smarty_tpl->tpl_vars['rule']->value) {
$_smarty_tpl->tpl_vars['rule']->_loop = true;
?>
		                    		<div>
						   				<div class="col-sm-7">&raquo; <?php echo $_smarty_tpl->tpl_vars['rule']->key;?>
</div>
						   				<div class="col-sm-5 align_right"><input type='checkbox' name='rules[<?php echo $_smarty_tpl->tpl_vars['rule']->key;?>
]' <?php if ($_smarty_tpl->tpl_vars['rule']->value) {?>checked="checked"<?php }?>   value='A' /> &nbsp; Permitir</div>
						   			</div>
		                    		<?php } ?>
		                    	</div>
		                    	<?php } else { ?>
		                    		<p>
	                    				<strong>Nenhuma regra cadastrada</strong><br />
	                    			</p>		                    	
		                    	<?php }?>
		                    	
		                    	<?php if ($_smarty_tpl->tpl_vars['ssxacl']->value['this_module']['rules']) {?>
	                    			<a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/rules" class="btn btn-small btn-default">Adicionar Regras do Projeto</a>
	                    		<?php }?>
		                    </div>
			         </div>
				</div>
			</div>
		</form>
	<?php } elseif ($_smarty_tpl->tpl_vars['group_permissions']->value=="all_access") {?>
	<p>
		Este grupo já possui permissão de acesso a todos os pontos do projeto e do admin
	</p>
	<?php }?>
</div><?php }} ?>
