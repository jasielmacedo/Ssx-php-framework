<div class='content'>
	<h2>{$locale->singular}: {$view.name}</h2>
	<span class='text-error'>{$view_error}</span>
	<dl class="dl-horizontal">
		<dt>Login</dt>
			<dd>{$view.user}</dd>
		<dt>Nome</dt>
			<dd>{$view.name}</dd>
		<dt>Email</dt>
			<dd>{$view.email}</dd>
		<dt>Criado em</dt>
			<dd>{$view.date_created|date_format:"%d/%m/%Y - %H:%M"} por {$view.created_by_name}</dd>
		<dt>Ultima alteração em</dt>
			<dd>{$view.date_modified|date_format:"%d/%m/%Y - %H:%M"} por {$view.modified_by_name}</dd>
	</dl>
	
		{if $ssxacl.this_module.edit}
		<div>
		  	 {if $view.id neq $ssx_guest_id}
		     <a href="{$siteurl}{$this_module}/edit/{$view.id}" class="btn btn-small btn-success"><i class="icon-pencil"></i> {$locale->edit}</a>
		     {/if}
		     {if $ssxacl.admin.auth.change_pass && $view.id neq $ssx_guest_id && !$is_your && $view.id neq $ssx_admin_id}
		      <a href="{$siteurl}auth/change_pass?id={$view.id}"  class="btn btn-small btn-info"><i class="icon-lock"></i> Trocar senha</a>
		     {/if}
		     {if !$is_your && $view.id neq $ssx_admin_id && $view.id neq $ssx_guest_id}
		    	 <a href="javascript:void(0);" data-type="status" data-status="{$view.status}" class="btn btn-small btn-warning action"><i class="icon-warning-sign"></i> {if $view.status eq "1"}Desativar{else}Ativar{/if} {$locale->singular}</a>
		     	 <a href="javascript:void(0);" data-type="delete" class="btn btn-small btn-danger action"><i class="icon-trash"></i> {$locale->delete}</a>
		  	 {/if}
		 </div>
		{/if}
	{$addicional_content}
</div>
{if $ssxacl.this_module.edit}
<script type='text/javascript'>

var singular = "{$locale->singular}";
var redirectUrl = "{$siteurl}{$this_module}/{$this_action}/{$view.id}";

</script>
{/if}