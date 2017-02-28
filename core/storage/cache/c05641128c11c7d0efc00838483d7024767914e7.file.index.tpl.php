<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 17:41:52
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Home\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1810657320140ab5fa9-34289440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c05641128c11c7d0efc00838483d7024767914e7' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Home\\templates\\index.tpl',
      1 => 1418847370,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1810657320140ab5fa9-34289440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'no_group' => 0,
    'ssxacl' => 0,
    'siteurl' => 0,
    'allow_pages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57320140ac9832_31729162',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57320140ac9832_31729162')) {function content_57320140ac9832_31729162($_smarty_tpl) {?><div class="content">
	<p>
		Bem-vindo ao sistema de administração
	</p>
	<?php if ($_smarty_tpl->tpl_vars['no_group']->value&&$_smarty_tpl->tpl_vars['ssxacl']->value['admin']['ssxproject']['index']) {?>
		<div class="alert alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Cuidado!</h4>
		  Não há grupo padrão para novos usuários. Entre em <a href='<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
ssxproject'>Configurações do Projeto</a> para configurar.
		</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['allow_pages']->value&&$_smarty_tpl->tpl_vars['ssxacl']->value['admin']['ssxproject']['index']) {?>
		<div class="alert alert-warning">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Aviso!</h4>
		  A exibição de página estáticas está desabilitada. Entre em <a href='<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
ssxproject'>Configurações do Projeto</a> e ative caso precise.
		</div>
	<?php }?>
</div>
<?php }} ?>
