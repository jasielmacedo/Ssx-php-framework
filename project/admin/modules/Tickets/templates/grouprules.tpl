<div class="content rules">
	<h2>Regras de Prioridade de Grupos</h2>
	{if $saved}
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  Regras salvas com sucesso.
		</div>
	{/if}
	<div class="margin_b_10">Edite a prioridade que cada grupo tem em relação a abertura de chamados.</div>
	<div class="row regras">
		<form action="{$siteurl}{$this_module}/{$this_action}" method="post">
			<div class="col-sm-12">
				<input type="submit" name="save" value="Salvar Alterações" class='btn btn-primary right' />
			</div>
			
			<div class='fields'>	
				{section name=i loop=$groups}
				<div class="col-sm-12 rule_empty fieldAlert overflow margin_t_10 margin_b_10" role="fieldAlert">
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">{$groups[i].name}</span>
					  <input type="text" name="groups[{$groups[i].id}]" value="{if $gsaved[$groups[i].id]}{$gsaved[$groups[i].id]}{else}1{/if}" class="form-control" style="width:10%" placeholder="Prioridade" aria-describedby="basic-addon1" />
					</div>
				</div>
				{/section}
			</div>			
		</form>
	</div>
</div>