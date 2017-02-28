<div class='content'>
	<h2>{$locale->singular}: {$view.name}</h2>
	<span class='text-error'>{$view_error}</span>
	<dl class="dl-horizontal">
		<dt>Nome:</dt>
			<dd>{$view.name}</dd>
		<dt>Descrição:</dt>
			<dd>{if $view.description}{$view.description}{else}---{/if}</dd>
		<dt>Criado em:</dt>
			<dd>{$view.date_created|date_format:"%d/%m/%Y &agrave;s %H:%Mh"} por {$view.created_by_name}</dd>
		<dt>Ultima alteração em:</dt>
			<dd class='field' style='font-size:11px'>{$view.date_modified|date_format:"%d/%m/%Y &agrave;s %H:%Mh"} por {$view.modified_by_name}</dd>
	</dl>
	<div>
		 	{if $ssxacl.this_module.edit}
		     <a href="{$siteurl}{$this_module}/edit/{$view.id}" class="btn btn-small btn-info action"><i class="icon-pencil"></i> {$locale->edit}</a>
		     {if $view.id neq $ssx_admin_group_id}
		    	 <a href="javascript:void(0);" data-type="status" data-status="{$view.status}" class="btn btn-small btn-warning action"><i class="icon-warning-sign"></i> {if $view.status eq "1"}Desativar{else}Ativar{/if} {$locale->singular}</a>
		     	<a href="javascript:void(0);" data-type="delete" class="btn btn-small btn-danger action"><i class="icon-trash"></i> {$locale->delete}</a>
		  	 {/if}
		  	{/if}
	</div>
	<hr />
	{if $users}
	<h4>Usuários do {$locale->singular}</h4>
	<table width="100%" class='table table-striped'>
	 <thead>
		<tr>
		    <th>&nbsp;</th>
			<th>Nome</th>
			<th>Email</th>
			<th>usu&aacute;rio</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$users}
		<tr class='item_line'>
		    <td width="5"><i class="icon-user"></i></td>
			<td>{$users[i].name}</td>
			<td>{$users[i].email}</td>
			<td>{$users[i].user}</td>
			<td>{if $users[i].status eq 1}Ativo{else}Inativo{/if}</td>
			<td align="right">
			 {if $ssxacl.admin.ssxusers.view} 
			  <a href="{$siteurl}ssxusers/view/{$users[i].id}" class="btn btn-small btn-info">ver usu&aacute;rio</a>
			 {/if}
			</td>
		</tr>
		{/section}
	</tbody>
	</table>
	{else}
		{if $view.level eq "2"}
		<p class='text-error'>Esse {$locale->singular} não pode ter usuário</p>
		{else}
		<p class='text-error'>Nenhum usuário nesse {$locale->singular}</p>
		{/if}
	{/if}
</div>
<script type='text/javascript'>
{if $ssxacl.this_module.edit}

	var singular = "{$locale->singular}";
	var redirectUrl = "{$siteurl}{$this_module}/{$this_action}/{$view.id}";

{/if}
</script>