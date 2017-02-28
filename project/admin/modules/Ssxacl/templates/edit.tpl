<div class='content'>
	<h2>{$locale->edit}</h2>
	{if $saved}
		<div class="alert alert-success">
			Dados Alterados com sucesso
		</div>
	{/if}
	<div class='error_field'>{$data_error}</div>
	<div class='content_group'>
		<form action="" method="post" id="filter_submit">
			<strong>Grupo:</strong>
			<select name="group_id" class="form-control inline w_250 margin_b_10" onchange="this.form.submit()">
				<option value="">-- Selecione</option>
				{foreach $groups as $group}
				<option {if $group_id eq $group.id}selected="selected"{/if} value="{$group.id}">{if $group.name eq "guest"}Visitante{else}{$group.name}{/if}</option>
				{/foreach}
			</select>
			<!-- <br />
			<input type='submit' class='btn btn-inverse' value='Editar permissões' /> -->
		</form>
	</div>
	{if $group_permissions && $group_permissions neq "all_access"}
		<form action="{$siteurl}{$this_module}/{$this_action}" method="post">
			<div class="row">
				<div class="col-sm-12 margin_b_20">
					<div class="col-sm-10">
						Ultima alteração em:
						{$p_details.date_modified|date_format:"%d/%m/%Y &agrave;s %H:%Mh"}
					</div>
					<div class="col-sm-2">
						<input type='hidden' name='group_id' value='{$group_id}' />
						{$field_secure}
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
								{foreach $group_permissions.access as $locals}
								   <div class="callout callout-success">
								   		<h4>{if $locals@key eq "admin"}Área administrativa{else}Acesso ao site{/if}</h4>
								   		
								   		<p>Permitir acesso <input type="checkbox" name="data[{$locals@key}][_access]" {if $locals._access} checked="checked"{/if} value="A" /></p>
								   		{foreach $locals.modules as $itens}
								   		
								   		<div class="margin_t_20">
								   			<span><strong>{$itens@key}</strong></span>
								   			{foreach $itens as $actions}
								   				{foreach $actions as $action}
										   			<div class="row">
										   				<div class="col-sm-6">&raquo; {$action@key}</div>
										   				<div class="col-sm-6 align_right"><input type='checkbox' name='data[{$locals@key}][modules][{$itens@key}][actions][{$action@key}]' {if $action}checked="checked"{/if} value='A' /> &nbsp; Permitir Acesso</div>
										   			</div>
										   		{/foreach}
										   	{/foreach}
								   		</div>
								   		
								   		{/foreach}
								   </div>
								{/foreach}
		                    </div>
			         </div>
				</div>
				<div class="col-sm-4">
					 <div class="panel panel-default">                    
		                    <div class="panel-heading bold">Regras de Uso</div>
		                    <div class="panel-body">
		                    	
		                    	<span class="f10">Regras de Uso são usadas pela área de programação do site. Caso não saiba como usa-las entre em contato com o administrador</span>
		                    	{if $group_permissions.rules}
		                    	<div class="row margin_t_10 margin_b_10">
		                    		{foreach $group_permissions.rules as $rule}
		                    		<div>
						   				<div class="col-sm-7">&raquo; {$rule@key}</div>
						   				<div class="col-sm-5 align_right"><input type='checkbox' name='rules[{$rule@key}]' {if $rule}checked="checked"{/if}   value='A' /> &nbsp; Permitir</div>
						   			</div>
		                    		{/foreach}
		                    	</div>
		                    	{else}
		                    		<p>
	                    				<strong>Nenhuma regra cadastrada</strong><br />
	                    			</p>		                    	
		                    	{/if}
		                    	
		                    	{if $ssxacl.this_module.rules}
	                    			<a href="{$siteurl}{$this_module}/rules" class="btn btn-small btn-default">Adicionar Regras do Projeto</a>
	                    		{/if}
		                    </div>
			         </div>
				</div>
			</div>
		</form>
	{else if $group_permissions eq "all_access"}
	<p>
		Este grupo já possui permissão de acesso a todos os pontos do projeto e do admin
	</p>
	{/if}
</div>