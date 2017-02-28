<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{$ssx_theme_title}</title>
	<link href="{$theme_url}/css/bootstrap.min.css" rel="stylesheet" />
    {$ssx_head}    
    <script src="{$theme_url}/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	 {if !$password_request}
      <form class="form-signin form" id="login-default" action="{$siteurl}{$this_module}/{$this_action}" method="post">
        <h3 class="form-signin-heading">Acesso Restrito</h3>
        {if $user_error}
        	<span class="label label-danger">{$user_error}</span>
        {/if}
        {if $recover}
         
        	<script type="text/javascript">Ssx.alert("{$recover}");</script>
        {/if}
        
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
        <input type='hidden' name='redirect' value='{$redirect}' />
        <input type="hidden" name="login" value="trigger" />
        
        {$field_token}
      </form>
      <form class="form-signin form" style="display:none" id="forgot-pass" action="{$siteurl}{$this_module}/{$this_action}" method="post">
      	<h3 class="form-signin-heading">Recupera&ccedil;&atilde;o de senha</h3>
      	<div class="control">
      		<span class="label label-danger" id="forgot_error"></span>
      		<input type="email" class="form-control input-block-level margin_b_10 required" required="required" name="forgot_email" id="forgot_email" data-type="email" data-error="#forgot_error" placeholder="Email">
      	</div>
      	<input type="hidden" name="forgot" value="trigger" />
      	<button class="btn btn-info" type="submit">Recuperar senha</button> 
      	| <a href="javascript:void(0);" class="backLogin">Voltar</a>
      	{$field_token}
      </form>
    {else}
       <form class="form-signin form" action="{$siteurl}{$this_module}/{$this_action}" method="post">
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
       	 
       	 <input type='hidden' name='redirect' value='{$redirect}' />
		 <input type='hidden' name='m' value='{$password_user}' />
		 <input type='hidden' name='t' value='{$password_token}' />
		 <input type="hidden" name="change_pass" value="trigger" />
         <button class="btn" type="submit">Salvar</button>
         {$field_token}
       </form>
   {/if}
</div>
<script type="text/javascript">
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
</script>

</body>
</html>