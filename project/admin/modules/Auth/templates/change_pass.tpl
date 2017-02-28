<div class='content well'>
 <h2 class='module_title'> Alterar senha</h2>
 Logado como: <strong>{$user.name}</strong>
 {if $userChange}
 <br />Trocando a senha de <strong><a href="{$siteurl}ssxusers/view/{$userChange.id}" target="_blank">{$userChange.name}</a></strong>
 {/if}
 <hr />
 {if $success}
 	<div class='alert alert-success'>{$success}</div>
 {/if}
 {if $pass_error}
 	<div class='alert alert-danger'>{$pass_error}</div>
 {/if}
  <div  class='overflow'>
 <form action="{$siteurl}{$this_module}/{$this_action}{if $userChange}?id={$userChange.id}{/if}" method="post" class='form' autocomplete='off'>
	 <div  class='col-lg-4 col-md-4 col-sm-6 col-xs-12'>
	 	{if !$user_is_other}
	 	<div>
	 		<span class='label label-danger' id='old_pass_error'></span>
		 	<div class="input-group margin_10">
			  <span class="input-group-addon" id="basic-addon1">Senha atual:</span>
			  <input type="password" name='old_pass' value=''  class="form-control required" placeholder="Digite a senha" aria-describedby="basic-addon1" data-min="6" data-error="#old_pass_error" data-type="pass">
			</div>
		</div>
		{/if}
		<div>
			<span class='label label-danger' id='new_pass_error'></span>
			<div class="input-group margin_10">
			  <span class="input-group-addon" id="basic-addon2">Nova Senha:</span>
			  <input type="password" name='new_pass' value='' id='new_pass' class="form-control required" placeholder="Digite a senha" data-compare="#new_pass_confirm" data-min="6" data-error="#new_pass_error" data-type="pass" aria-describedby="basic-addon2">
			</div>
		</div>
		<div>
			<span class='label label-danger' id='new_pass_error_confirm'></span>
			<div class="input-group margin_10">			  
			  <span class="input-group-addon" id="basic-addon3">Confirmar Senha:</span>
			  <input type="password" name='new_pass_confirm' id="new_pass_confirm" value='' class="form-control required" placeholder="Digite a senha" data-min="6" data-error="#new_pass_error_confirm" data-type="pass" aria-describedby="basic-addon3">
			</div>
		</div>
		<div class="margin_10">
			<input type='hidden' name='saveChange' value="trigger" />
			{$field_token}
			<button type='submit' class='btn btn-primary margin_t_10'>Alterar</button>
		</div>
	 </div>
 </form>
 </div>
 </div>
 <script type='text/javascript'>
 	jQuery(document).ready(function ($) {	
		$('.form').submit(function(){
			if(Ssx.validate(this))
				return true;
			return false;
	
		});
	});
 </script>