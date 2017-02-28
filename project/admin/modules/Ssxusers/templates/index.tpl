<div class="content">
	<h2>{$locale->plural}</h2>
	<div>
		{if $ssxacl.this_module.edit}
		<a href="{$siteurl}{$this_module}/edit" class='btn btn-success margin_b_10'><i class="icon-plus icon-white"></i> {$locale->add}</a>
		{/if}
	</div>
	
	{if $user_deleted}
		<div id='popup' class='alert alert-success clear'>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			{$locale->singular} deletado com sucesso
		</div>
	{/if}	
</div>
<div class='content-list table-responsive clear'>
	 <div class="right margin_b_10">
			<form action="{$siteurl}{$this_module}/{$this_action}" method="get" class="form-inline">
				<div class="form-group">
				    <p class="form-control-static"><label class="label label-default">Buscar por:</label> </p>
				 </div>
				 <div class="form-group">
					<div class="input-group margin_r_10 w_300">
						<span class="input-group-addon">Grupos</span>
						<select class="form-control w_200" name="user_group">
							<option value="">Todos os grupos</option>
							{html_options options=$groups selected=$group_selected}
						</select>
					</div>
				</div>	
				<div class="form-group">
					<div class="input-group w_300">		
					  {if $search_query}<span class="input-group-btn"><a title='Limpar Busca' class='btn' href="{$siteurl}{$this_module}/{$this_action}"><i class='icon-remove'></i></a></span>{/if}
					  <input type="text" class="form-control" name="s" value="{$search_query}" placeholder="nome do {$locale->singular}" maxlength="255">
					  <span class="input-group-btn">
				         <input class="btn btn-default" type="submit" value="{$locale->search}">
				      </span>
					</div>
				</div>
							
			</form>
		</div>
	{if $search_query}
		<h4>{$locale->search} por: {$search_query}</h4>
	{/if}
	{if $pagination}
	<ul class="pagination">
			{section name=i loop=$pagination}
				{if $pagination[i] neq $pagination_page}
					<li><a class='btn btn-small btn-inverse' href="{$siteurl}{$this_module}/{$this_action}?page={$pagination[i]}{if $search_query}&s={$search_query}{/if}">{$pagination[i]}</a></li>
				{else}
					<li class='active'><a class='btn btn-small disabled' href='javascript:void(0);'>{$pagination[i]}</a></li>
				{/if}				
			{/section}
	</ul>
	<div class="clear"></div>
	{/if}
	{if $all}
	<table width="100%" class='table table-striped clear'>
	<thead>
		<tr>
		    <th>&nbsp;</th>
			<th>Nome</th>
			<th>Email</th>
			<th class='hidden-xs'>usu&aacute;rio</th>
			<th class='hidden-xs'>Criado em</th>
			<th class='hidden-xs'>Ultima modificação em</th>
			<th class='hidden-xs'>Status</th>
			<th width="15%">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$all}
		<tr class='item_line'>
		    <td width="5"><i class="icon-user"></i></td>
			<td>{$all[i].name}</td>
			<td>{$all[i].email}</td>
			<td class='hidden-xs'>{$all[i].user}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_created|date_format:"%d/%m/%Y &agrave;s %H:%Mh"} por {$all[i].created_by_name}</td>
			<td class='hidden-xs' style='font-size:11px'>{$all[i].date_modified|date_format:"%d/%m/%Y &agrave;s %H:%Mh"} por {$all[i].modified_by_name}</td>
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
	<p class='text-error'>Nenhum {$locale->singular} cadastrado</p>
	{/if}
</div>