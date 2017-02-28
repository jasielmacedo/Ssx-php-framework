<div class="content">
	<h2>{$locale->singular}</h2>
	<div class='content well'>
		<h4>{if $edit}{$locale->edit}{else}{$locale->add}{/if} {$locale->singular} {if $edit}<a href="{$siteurl}{$this_module}/{$this_action}" class="btn btn-small btn-danger">Cancelar Edição</a>{/if}</h4>
		
		{if $data_error}
			<div class='alert alert-danger'>{$data_error}</div>
		{/if}
		{$fields}
	</div>
	<script type='text/javascript'>
		{$js_content}
	</script>	
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
			<th width="40%">Nome</th>
			<th class='hidden-xs'>Criado em</th>
			<th class='hidden-xs'>Ultima modificação em</th>
			<th width='20%'>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$all}
		<tr class='item_line'>
		    <td nowrap="nowrap" width="5"><i class="icon-bookmark"></i></td>
			<td>{$all[i].object_name}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_created|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_modified|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
			<td align="right">
			  	<a href="{$siteurl}{$this_module}/{$this_action}/{$all[i].id}" class="btn btn-small btn-info">{$locale->edit}</a>
			  	<a href="{$siteurl}{$this_module}/{$this_action}/{$all[i].id}?delete=true" class="btn btn-small btn-warning remove">{$locale->delete}</a>
			</td>
		</tr>
		{/section}
	</tbody>
	</table>
	{else}
		<p class='label label-warning'>Nenhum {$locale->singular} cadastrado</p>
	{/if}
</div>
<script type="text/javascript">
	$(function(){
		$('.remove').click(function(){
			if(confirm("Tem certeza remover esse tipo de chamado? Se houver algum chamado cadastrado com ele, não será possível remover."))
				return true;
			return false;
		});
	});
</script>