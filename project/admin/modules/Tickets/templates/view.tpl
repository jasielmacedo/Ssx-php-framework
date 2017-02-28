<div class="container">
	<h2>Chamado: #{$view.id} {if $view.status eq "3"}- <i>Resolvido</i>{/if}</h2>
	{if $ticket_reply}
		<div class="alert alert-success">Resposta removida com sucesso.</div>
	{else if $ticket_changed}
		<div class="alert alert-success">Status do Ticket Alterado com sucesso.</div>
	{/if}
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<div class="pull-right">
			  		<a href="{$siteurl}{$this_module}/{$this_action}/{$view.id}?addReply=true#add" class="btn btn-primary"><i class="icon-share icon-white"></i> Responder</a>
		  			<a href="javascript:void(0);" title="Remover" class="btn btn-danger remover" data-add="?delete=true"><i class="icon-trash icon-white"></i></a>
		  		</div>
			  	<h3 class='panel-title'><strong>{$view.title}</strong></h3>
			  </div>
			  <div class="panel-body">
			  		<blockquote class="f12"><strong>Criado por: </strong> {$view.created_by_name}<br />
			  			<strong>Enviado em: </strong> {$view.date_created|date_format:"%d/%m/%Y &agrave;s %H:%Mh"}<br />
			  			<strong>Prioridade: {for $key=1 to $view.priority}<i class="icon-star"></i>{/for}</strong>
					</blockquote>
					{section name=i loop=$replies}
						<div class="panel panel-default">
						  <div class="panel-heading f12">
						  	<a name="{$replies[i].id}"></a>
						  	Enviado por: <strong>{$replies[i].created_by_name}</strong> em: {$replies[i].date_created|date_format:"%d/%m/%Y &agrave;s %H:%Mh"}
						  	{if $smarty.section.i.index > 0 && $replies[i].created_by eq $userid}
						  		<div class="pull-right">
						  			<a href="javascript:void(0);" title="Remover" data-add="?deleteReply={$replies[i].id}" class="btn btn-danger remover"><i class="icon-remove icon-white"></i></a>
						  		</div>
						  	{/if}
						  </div>
						  <div class="panel-body">
						  		{$replies[i].content}
						  </div>
						</div>
					{/section}
					{if !$reply}
						<div class="can-reply clear">
							<a href="{$siteurl}{$this_module}/{$this_action}/{$view.id}?addReply=true#add" class="btn btn-primary"><i class="icon-share icon-white"></i> Responder</a>
						</div>
					{else}
						<a name="add"></a>
						<form action="{$siteurl}{$this_module}/{$this_action}/{$view.id}" method="post">
							<div class="panel panel-warning">
							  <div class="panel-heading f12">
							  	Adicionar resposta
							  </div>
							  <div class="panel-body">
							  		{$ssx_editor}
							  </div>
							  <div class="panel-footer">
							  	 
							  	 <input type="submit" class="btn btn-primary" value="Responder" name="saveValues" />
							  	 <a href="{$siteurl}{$this_module}/{$this_action}/{$view.id}" class="btn btn-danger"><i class="icon-remove icon-white"></i> Cancelar</a>
							  </div>
							</div>
						</form>
					{/if}
			  </div>
			</div>	
				
		</div>
		<div class="col-md-4">
			<div class="panel panel-success">
			  <div class="panel-heading">Definições</div>
			  <div class="panel-body">
			  	<h3>Status: {if $view.status eq 1}Aguardando{else if $view.status eq 2}Em andamento{else}Resolvido{/if}</h3>
			  	<form action="{$siteurl}{$this_module}/{$this_action}/{$view.id}" method="get">
			  		<p>Trocar Status do Chamado</p>
			  		<select name="changeStatus" class="form-control">
			  			<option value="">-- Selecione</option>
			  			{html_options options=$options}
			  		</select>
			  		<input type="submit" value="Atualizar" class="btn btn-success margin_t_10" />
			  	</form>
			  </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var remAdd;

	$(function()
	{
		$('.remover').click(function(){
			remAdd = $(this).attr("data-add");
			
			Ssx.confirm(function()
			{
				window.location.href = "{$siteurl}{$this_module}/{$this_action}/{$view.id}"+remAdd;
			},"Tem certeza que deseja remover este item?");
		});
	});
</script>