<div class="content">
	<h2>{$locale->plural}</h2>
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
			<th class='hidden-xs'>IP</th>
			<th width="45%">Mensagem de Log</th>
			<th class='hidden-xs'>User-Agent</th>
			<th class='hidden-xs'>Criado em</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$all}
		<tr class='item_line'>
		    <td nowrap="nowrap" width="5"><i class="icon-info-sign"></i></td>
		    <td>{$all[i].user_ip}</td>
			<td>{$all[i].status}</td>
			<td>{$all[i].user_agent}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_created|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
		</tr>
		{/section}
	</tbody>
	</table>
	{else}
		<p class='label label-warning'>Nenhum {$locale->singular} salvo</p>
	{/if}
</div>