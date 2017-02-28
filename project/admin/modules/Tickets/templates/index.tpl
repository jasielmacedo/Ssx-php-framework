<div class="content">
	<h2>{if $this_action eq "my"}Meus{/if} {$locale->plural}</h2>
	{if $ssxacl.this_module.add}
		<a href="{$siteurl}{$this_module}/add" class='btn btn-success margin_b_10'><i class="icon-plus"></i> {$locale->add}</a>
	{/if}
	{if $notypes}
	<div class="alert alert-warning">{if $ssxacl.this_module.tipos}É necessário criar tipos de chamados para abrir chamados.{else}Não há tipos de chamados disponíveis para serem abertos.{/if}</div>
	{/if}
</div>
<div class='content-list'>
	{if $pagination}
	<div class="pagination">
		   <div class='pages'>
		   	<p class='page_item'>
			{section name=i loop=$pagination}
				{if $pagination[i] neq $pagination_page}
					<a class='btn btn-small btn-inverse btn-default' href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a>
				{else}
					<a class='btn btn-small disabled btn-default' href="javascript:void(0);">{$pagination[i]}</a>
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
		    <th>Numero</th>
			<th width='30%'>Título do chamado</th>
			{if $ssxacl.this_module.tipos}
			<th class='hidden-xs' width='10%'>Prioridate</th>
			{/if}
			<th class='hidden-xs'>Categoria</th>
			<th class='hidden-xs'>Enviado por</th>
			<th class='hidden-xs'>última mensagem</th>
			<th class='hidden-xs'>Status</th>
			<th width='10%'>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$all}
		<tr class='item_line' {if $all[i].status eq 3}style='color:#dddddd'{/if}>
		    <td nowrap="nowrap" width="5"><i class="icon-info-sign"></i></td>
		    <td>#{$all[i].id}</td>
			<td>{$all[i].title}</td>
			{if $ssxacl.this_module.tipos}
			<td class='hidden-xs'>{for $key=1 to $all[i].priority}<i class="icon-star"></i>{/for}</td>
			{/if}
			<td class='hidden-xs'>{$all[i].type}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].created_by_name} - {$all[i].date_created|date_format:"%d/%m/%Y - %H:%M"}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].last_reply.by} - {$all[i].last_reply.date|date_format:"%d/%m/%Y - %H:%M"}</td>
			<td class='hidden-xs'>{if $all[i].status eq 1}Aguardando{else if $all[i].status eq 2}Em andamento{else}Resolvido{/if}</td>
			{if $ssxacl.this_module.view}
			<td align="right">
			  	<a href="{$siteurl}{$this_module}/view/{$all[i].id}" class="btn btn-small btn-info" title="Ver Chamado"><i class="icon-eye-open icon-white"></i></a>
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