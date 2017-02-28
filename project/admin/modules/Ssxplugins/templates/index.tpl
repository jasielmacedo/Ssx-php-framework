<div class="content">
	<h2>{$locale->plural}</h2>
	<br />
	{if $ssxacl.this_module.install}
	<a href="{$siteurl}{$this_module}/install" class='btn btn-small btn-success'><i class="icon-pencil"></i> Instalar novo {$locale->singular}</a><br /><br />
	{/if}
	Para ativar ou desativar um {$locale->singular} é necessário que o mesmo tenha o arquivo manifest.xml configurado corretamente
</div>
<div class='content-list'>
	{if $pagination}
	<div class="pagination">
		   <div class='pages'>
		   	<p>
			{section name=i loop=$pagination}
				
				{if $pagination[i] neq $pagination_page}
					<a class='btn btn-small' href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}">{$pagination[i]}</a>
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
	<p>
		<span class='text-error'>{$data_error}</span>
	</p>
	<table width="100%" class='table table-striped'>
		{section name=i loop=$all}
		<tr class='item_line'>
			<td>{$all[i].real_name}</td>
			<td class='hidden-xs'>{$all[i].description}</td>
			<td class='hidden-xs' style='text-align:center;'>{if $all[i].active eq 1}<i class="icon-ok"></i>{else}<i class="icon-off"></i>{/if}</td>
			{if $ssxacl.this_module.install}
			<td align="right" width="30%">

			  {if $all[i].has_config && $all[i].active eq 1}
			  <a href="{$siteurl}{$this_module}/config/{$all[i].reference_name}" class="btn btn-small btn-info"><i class="icon-tasks"></i> Configurar</a>
			  {/if}
			  
			  {if $all[i].active eq 1}
			  <a href="javascript:void(0);" data-type="desactive" data-id="{$all[i].id}" class="btn btn-small btn-warning action"><i class="icon-off"></i> Desativar</a>
			  {else}
			  <a href="javascript:void(0);" data-type="active" data-id="{$all[i].id}" class="btn btn-small btn-warning action"><i class="icon-ok"></i> Ativar</a>
			  {/if}
			  <a href="javascript:void(0);" data-type="remove" data-id="{$all[i].id}" class="btn btn-small btn-danger action"><i class="icon-trash"></i> {$locale->delete}</a>
			</td>
			{/if}
		</tr>
		{/section}
	</table>
	<script typ='text/javacript'>
		var singular = "{$locale->singular}";
	
	 {literal}
		$(function(){
			$('.action').click(function(){
				var type = $(this).attr('data-type');
				var id = $(this).attr('data-id');
				
				switch(type)
				{
					case "active":
						Ssx.confirm(function(){
							location.href = "?active=true&plugin_id="+id;
						},"Tem certeza que deseja reativar esse "+singular+"?");
					break;
					case "desactive":
						Ssx.confirm(function(){
							location.href = "?desactive=true&plugin_id="+id;
						},"Tem certeza que deseja desativar esse "+singular+"?");
					break;
					case "remove":
						Ssx.confirm(function(){
							location.href = "?delete=true&plugin_id="+id;
						},"Tem certeza que deseja remover o {$locale->singular}?");
					break;
				}
			});
		});
	{/literal}
	</script>
	{else}
	<p class='text-error'>Nenhum {$locale->singular} instalado</p>
	{/if}
</div>