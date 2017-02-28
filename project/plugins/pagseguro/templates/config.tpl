<div class='content well'>
	<h2> {$locale->singular} - Forma de Pagamento - PagSeguro</h2>
	{if $saved}
		<div class="alert alert-success">
		  <button type="button" class="close" data-dismiss="alert">&times;</button> Dados salvos com sucesso
		</div>
	{/if}
	{$fields}
</div>
<script type='text/javascript'>
	{$js_content}
</script>