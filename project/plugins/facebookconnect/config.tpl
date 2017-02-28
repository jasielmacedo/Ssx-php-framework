<div class='content'>
	<h1 class='module_title'>Facebook Connect Plugin - Configurações</h1>
	{if $data_error}
	<div class='alert alert-warning'>{$data_error}</div>
	{/if}
</div>

<div>
	<p>Configure aqui os dados da aplicação no facebook</p>
	{$fields}
</div>
<script type='text/javascript'>
	{$js_content}
</script>