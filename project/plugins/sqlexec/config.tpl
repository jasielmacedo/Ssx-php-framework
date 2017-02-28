<div class="row">
	<div class="alert alert-warning">
		Atenção: O plugin serve apenas para execução de comandos simples. Comandos mais complexos de alteração de configuração não serão executados.
	</div>
	{$construct}
	
	{if $view}
	<div class="margin_t_10">
		<pre>{$view}</pre>
	</div>
	{/if}
</div>
<script type="text/javascript">
{$js_content}
</script>