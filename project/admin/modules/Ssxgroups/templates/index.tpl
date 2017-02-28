<div class="content">
	<h2>{$locale->plural}</h2>
	{if $ssxacl.this_module.edit}
		<a href="{$siteurl}{$this_module}/edit" class='btn btn-success margin_b_10'><i class="icon-plus"></i> {$locale->add}</a>
	{/if}
	
	{if $group_deleted}
	<div id='popup' class='alert alert-success'>{$locale->singular} deletado com sucesso</div>
	<script type='text/javascript'>
		setTimeout(function(){ $('#popup').fadeOut(); }, 3000);
	</script>
	{/if}	
</div>
<div class='content-list'>
	{if $pagination}
	<div class="pagination">
		   <div class='pages'>
		   	<p class='page_item'>
			{section name=i loop=$pagination}
				{if $pagination[i] neq $pagination_page}
					<a class='btn btn-small btn-inverse' href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a>
				{else}
					<a class='btn btn-small disabled' href="javascript:void(0);">{$pagination[i]}</a>
				{/if}
			{/section}
			</p>
			<div class="clear"></div>
		  </div>
		  <div class="clear"></div>
	</div>
	{/if}
	{if $all}
	<table width="100%" class='table table-striped'>
	<thead>
		<tr>
		    <th>&nbsp;</th>
			<th>Nome</th>
			<th class='hidden-xs'>Criado em</th>
			<th class='hidden-xs'>Ultima modificação em</th>
			<th class='hidden-xs'>Status</th>
			<th width='20%'>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$all}
		<tr class='item_line'>
		    <td nowrap="nowrap" width="5"><i class="icon-briefcase"></i></td>
			<td>{$all[i].name}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_created|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_modified|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
			<td class='hidden-xs'>{if $all[i].status eq 1}Ativo{else}Inativo{/if}</td>
			{if $ssxacl.this_module.view}
			<td align="right">
			  	<a href="{$siteurl}{$this_module}/view/{$all[i].id}" class="btn btn-small btn-info">{$locale->view}</a>
			</td>
			{/if}
		</tr>
		{/section}
	</tbody>
	</table>
	{else}
	<p class='label label-warning'>Nenhum {$locale->singular} cadastrado</p>
	{/if}
</div>