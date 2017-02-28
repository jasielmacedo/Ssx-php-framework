<div class="content rules">
	<h2>{$locale->singular}</h2>
	<a href="{$siteurl}{$this_module}/edit" class="btn btn-default margin_b_10">Editar Permissões</a>
	{if $saved}
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		  Regras salvas com sucesso.
		</div>
	{/if}
	<div class="margin_b_10">Adicione regras e salve para edita-las<br />O nome da regra será usado para consultas em back-end, não usar <strong>acentos ou espaços</strong>.</div>
	<div class="row regras">
		<form action="{$siteurl}{$this_module}/{$this_action}" method="post">
			<div class="col-sm-12">
				<input type="submit" name="save" value="Salvar Alterações" class='btn btn-primary right' />
			</div>
			
			<div class='fields'>	
				<div class="col-sm-12 rule_empty hide fieldAlert overflow margin_t_10 margin_b_10" role="fieldAlert">
					<input type="text" name="rules[]" value="" class='form-control w_p_25 left' placeholder="Nome da Regra" />
					<button type="button" class="close left margin_l_10" data-dismiss="fieldAlert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>
				{if $rules}
					{section name=i loop=$rules}
						<div class="col-sm-12 fieldAlert overflow margin_t_10 margin_b_10" role="fieldAlert">
							<input type="text" name="rules[]" value="{$rules[i]}" class='form-control w_p_25 left' placeholder="Nome da Regra" />
							<button type="button" class="close left margin_l_10" data-dismiss="fieldAlert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>
					{/section}
				{/if}
			</div>
			<div class="col-sm-12 margin_t_10 margin_b_10">
				<a href="javascript:void(0);" id="add_new_field">Adicionar Nova Regra</a>
			</div>
			
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#add_new_field').click(function(){
			var clone = $('.rule_empty').clone();

			clone.removeClass('rule_empty hide');
			clone.appendTo('.fields');
		});

		$('.close').live('click', function(){
			$(this).parent().remove();
		});
	});
</script>