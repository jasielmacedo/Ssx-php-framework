{if $denied}
<div class="alert alert-danger">
	<strong><i class="icon-warning-sign "></i> Permissão negada</strong> Você não tem acesso a edição desse chamado. Somente chamados de criação própria podem ser editados.
</div>
{else}

	{if $data_error}
		<div class="alert alert-danger">
			<strong><i class="icon-warning-sign "></i> Erro ao cadastrar</strong> {$data_error}
		</div>
	{/if}

<form action="" method="post" class="form">
<div class="container">	
	<div class="col-md-8">
		<div class="panel panel-info">
		  <div class="panel-heading">
		  	<h3 class='panel-title'>Novo Chamado</h3>
		  </div>
		  <div class="panel-body">
	    		<div class="form-group">	 
	    			 <label for="title" class='f16'>Título do chamado</label>
	    			 <span class='label label-danger' id='field_title_error'></span>
	    			 <input type='text' name='title' id='field_title' class='form-control required' data-min="4" data-error="#field_title_error" value='{$edit.title}' placeholder="Insira o título" />
	    		</div>
	    		<a href="javascript:void(0);" class='btn btn-small btn-default' onclick="openBox()" title="Adicionar Imagem"><i class='icon-camera'></i> Adicionar Imagem</a>
	    		<div class='margin_l_15 margin_r_15 table-responsive'>
		    		<div class="row">
		    			{$ssx_editor}
		    		</div>
	    		</div>
		  </div>			  
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-info">
		  <div class="panel-heading">
		  	<h3 class='panel-title'>Configurações</h3>
		  </div>
		  <div class="panel-body">
			  <div class="form-group">
			  		<label for="status" class='f16'>Tipo</label>
			  		<span class='label label-danger' id='field_ticket_type_error'></span>
				    <select id="field_ticket_type" name='ticket_type' class="form-control required" data-error="#field_ticket_type_error">
						<option value="">-- Selecione</option>
						{html_options options=$tipos}
					</select>
			  </div>
			  {$fieldsecure}
			  <input type="hidden" name='saveValues' value="saveValues" />
			  <button type='submit' class='btn btn-primary margin_t_10 form-control'><i class="icon-pencil icon-white"></i> {if $edit}Atualizar{else}Abrir Chamado{/if}</button>
		  </div>			  
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
var tagsAdded = [];

{$js_content}
</script>
{/if}