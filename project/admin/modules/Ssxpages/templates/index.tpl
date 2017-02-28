<div class="row>
	<div class="content">
		{if $allow_error && $ssxacl.admin.ssxproject.index}
			<div class="alert alert-danger">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <h4>Aviso!</h4>
			  A exibição de páginas para {$locale->singular} está desabilitada. Entre em <a href='{$siteurl}ssxproject'>Configurações do Site</a> e ative.
			</div>
		{/if}
		<h2>{$locale->plural}</h2>
		{if $ssxacl.this_module.edit}
			<a href="{$siteurl}{$this_module}/edit" class='btn btn-success margin_b_10'><i class='icon-plus'></i> {$locale->add}</a>
		{/if}
		
		{if $group_deleted}
		<div id='popup' class='alert alert-success'>{$locale->singular} deletado com sucesso</div>
		<script type='text/javascript'>
			setTimeout(function(){ $('#popup').fadeOut(); }, 3000);
		</script>
		{/if}	
	</div>
	<div class='content-list'>
		<div class="w_300 right">
			<form action="" method="get">
				<div class="input-group right">			  
				  <input type="text" class="form-control" name="s" value="{$search_query}" placeholder="{$locale->search} por nome do {$locale->singular}">
				  <span class="input-group-btn">
			         <input class="btn btn-default" type="submit" value="{$locale->search}">
			      </span>
				</div>
			</form>
		</div>
		{if $search_query}
		<h4>{$locale->search} por: {$search_query}</h4>
		{/if}
		{if $pagination}
		<div class="pagination">
			   <div class='pages'>
				{section name=i loop=$pagination}
					<div class='page_item'>
					{if $pagination[i] neq $pagination_page}
						<a href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}{if $search_query}&s={$search_query}{/if}">{$pagination[i]}</a>
					{else}
						{$pagination[i]}
					{/if}
					</div>
				{/section}
				<div class="clear"></div>
			  </div>
			  <div class="clear"></div>
		</div>
		{/if}
		{if $all}
		<table width="100%" class='table table-striped clear'>
		<thead>
			<tr>
			    <th>&nbsp;</th>
				<th>Título</th>
				<th>Url</th>
				<th>Criado em:</th>
				<th>Ultima modificação em:</th>
				<th>Status</th>
				<th width='20%'>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			{section name=i loop=$all}
			<tr class='item_line'>
			    <td width="5"><i class='icon-tag'></i></td>
				<td>{$all[i].title}</td>
				<td width='25%'>{$projecturl}<strong>{$all[i].slug}</strong></td>
				<td style='font-size:11px'>{$all[i].date_created|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
				<td style='font-size:11px'>{$all[i].date_modified|date_format:"%d/%m/%Y - %H:%M"} por {$all[i].created_by_name}</td>
				<td>{if $all[i].status eq 1}Publicada{else}Desativa{/if}</td>
				{if $ssxacl.this_module.view}
				<td align="right">
					{if $ssxacl.this_module.edit}
					<a href="{$siteurl}{$this_module}/edit/{$all[i].id}" class="btn btn-small btn-success"><i class='icon-pencil'></i> {$locale->edit}</a>
					{/if}
				  	<a href="{$siteurl}{$this_module}/view/{$all[i].id}" class="btn btn-small btn-info">{$locale->view}</a>
				</td>
				{/if}
			</tr>
			{/section}
		</tbody>
		</table>
		{else}
		<hr />
		<p class='text-error'>Nenhum {$locale->singular} {if $search_query}encontrado para <strong>{$search_query}</strong>{else}cadastrado{/if}</p>
		{/if}
	</div>
</div>