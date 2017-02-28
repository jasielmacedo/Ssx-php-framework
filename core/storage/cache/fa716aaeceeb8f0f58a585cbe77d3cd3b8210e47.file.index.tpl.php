<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 18:00:15
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxacl\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:311505732058fac20a4-61944606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa716aaeceeb8f0f58a585cbe77d3cd3b8210e47' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxacl\\templates\\index.tpl',
      1 => 1340660444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '311505732058fac20a4-61944606',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'image_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5732058fae91b2_11738621',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5732058fae91b2_11738621')) {function content_5732058fae91b2_11738621($_smarty_tpl) {?><div class="content">

	<h1 class='module_title'><img src="<?php echo $_smarty_tpl->tpl_vars['image_url']->value;?>
big/lock.gif" align="middle" />&nbsp; Acl : Permissão de acesso de usuários</h1>
	
	<p>
		Todas as alterações feitas aos grupos alterarão, diretamente todos os usuários que pertencem a ele<br />
		Grupo de administradores, não é possível alterar as suas permissões, pois ele tem acesso total ao sistema
	</p>
</div>
<?php }} ?>
