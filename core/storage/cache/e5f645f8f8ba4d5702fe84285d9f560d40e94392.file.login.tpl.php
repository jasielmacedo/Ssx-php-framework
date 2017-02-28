<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-11 22:53:13
         compiled from "E:\dropbox\Dropbox\dontmissone.com\project\admin\modules\Auth\templates\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1389257339bb9940ae9-38593549%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5f645f8f8ba4d5702fe84285d9f560d40e94392' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\dontmissone.com\\project\\admin\\modules\\Auth\\templates\\login.tpl',
      1 => 1462897995,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1389257339bb9940ae9-38593549',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ssx_theme_title' => 0,
    'theme_url' => 0,
    'ssx_head' => 0,
    'password_request' => 0,
    'siteurl' => 0,
    'this_module' => 0,
    'this_action' => 0,
    'user_error' => 0,
    'recover' => 0,
    'redirect' => 0,
    'field_token' => 0,
    'password_user' => 0,
    'password_token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_57339bb998ecf3_69250533',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57339bb998ecf3_69250533')) {function content_57339bb998ecf3_69250533($_smarty_tpl) {?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['ssx_theme_title']->value;?>
</title>
	<link href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/css/bootstrap.min.css" rel="stylesheet" />
    <?php echo $_smarty_tpl->tpl_vars['ssx_head']->value;?>
    
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="container">
	 <?php if (!$_smarty_tpl->tpl_vars['password_request']->value) {?>
      <form class="form-signin form" id="login-default" action="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" method="post">
        <h3 class="form-signin-heading">Acesso Restrito</h3>
        <?php if ($_smarty_tpl->tpl_vars['user_error']->value) {?>
        	<span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['user_error']->value;?>
</span>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['recover']->value) {?>
         
        	<?php echo '<script'; ?>
 type="text/javascript">Ssx.alert("<?php echo $_smarty_tpl->tpl_vars['recover']->value;?>
");<?php echo '</script'; ?>
>
        <?php }?>
        
        <div class="control-group">
	        <div class="control">
	        	<span class="label label-danger" id="user_error"></span>
	        	 <input type="text" class="form-control input-block-level required" required="required" name="user" id="user" data-min="5" data-error="#user_error" placeholder="Usuário" />
	        </div>
	        <div class="control">
	         	<span class="label label-danger" id="pass_error"></span>
	        	 <input type="password" class="form-control input-block-level required" required="required" name="pass" id="pass" data-min="3" data-error="#pass_error"  data-type="pass" placeholder="Senha"/>
	        </div>
        </div>   
        <div class="margin_t_10 margin_b_10">
        	<button class="btn w_full btn-success" type="submit">Entrar</button>
        	
        	<a href="javascript:void(0);" class="btn btn-info btn-small f10 margin_b_10 margin_t_10 lostMyPass w_full">Esqueci minha senha</a>
        </div>            
        <input type='hidden' name='redirect' value='<?php echo $_smarty_tpl->tpl_vars['redirect']->value;?>
' />
        <input type="hidden" name="login" value="trigger" />
        
        <?php echo $_smarty_tpl->tpl_vars['field_token']->value;?>

      </form>
      <form class="form-signin form" style="display:none" id="forgot-pass" action="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" method="post">
      	<h3 class="form-signin-heading">Recupera&ccedil;&atilde;o de senha</h3>
      	<div class="control">
      		<span class="label label-danger" id="forgot_error"></span>
      		<input type="email" class="form-control input-block-level margin_b_10 required" required="required" name="forgot_email" id="forgot_email" data-type="email" data-error="#forgot_error" placeholder="Email">
      	</div>
      	<input type="hidden" name="forgot" value="trigger" />
      	<button class="btn btn-info" type="submit">Recuperar senha</button> 
      	| <a href="javascript:void(0);" class="backLogin">Voltar</a>
      	<?php echo $_smarty_tpl->tpl_vars['field_token']->value;?>

      </form>
    <?php } else { ?>
       <form class="form-signin form" action="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;
echo $_smarty_tpl->tpl_vars['this_module']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['this_action']->value;?>
" method="post">
       	<h3 class="form-signin-heading"> Cadastrar nova senha</h3>
       	 
       	 <span class="text-error" id="new_pass_error"></span>
       	 <div class="control">
       	 	<span class="label label-danger" id="new_pass_list_error"></span>
       	 	<input type="password" class="form-control input-block-level required" required="required" name="new_pass" data-type="pass" data-length="6" data-compare="#new_pass_confirm" data-error="#new_pass_list_error" id="new_pass" placeholder="Nova Senha" />
       	 </div>
       	 <div class="control">
       	 	<span class="label label-danger" id="new_pass_compare_list_error"></span>
       	 	<input type="password" class="form-control input-block-level required" required="required" name="new_pass_confirm" data-type="pass" id="new_pass_confirm" data-length="6" data-error="#new_pass_compare_list_error" placeholder="Confirmar Senha" />
       	 </div>	 
       	 
       	 <input type='hidden' name='redirect' value='<?php echo $_smarty_tpl->tpl_vars['redirect']->value;?>
' />
		 <input type='hidden' name='m' value='<?php echo $_smarty_tpl->tpl_vars['password_user']->value;?>
' />
		 <input type='hidden' name='t' value='<?php echo $_smarty_tpl->tpl_vars['password_token']->value;?>
' />
		 <input type="hidden" name="change_pass" value="trigger" />
         <button class="btn" type="submit">Salvar</button>
         <?php echo $_smarty_tpl->tpl_vars['field_token']->value;?>

       </form>
   <?php }?>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
		jQuery(document).ready(function ($) {	
			$('.form').submit(function(){
		
				if(Ssx.validate(this))
					return true;
				return false;
		
			});
			
			$('.lostMyPass').click(function(){
				$('#login-default').slideUp();
				$('#forgot-pass').slideDown();
				return false;
			});
			
			$('.backLogin').click(function(){
				$('#forgot-pass').slideUp();
				$('#login-default').slideDown();
				return false;
			});
		});
<?php echo '</script'; ?>
>

</body>
</html><?php }} ?>
