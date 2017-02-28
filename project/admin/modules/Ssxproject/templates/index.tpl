<div class='content well'>
	<h2> {$locale->plural}</h2>
	{if $data_error}
		<div class='alert alert-danger'>{$data_error}</div>
	{/if}
	{if $saved}
		<div class='alert alert-success'>Dados alterados com sucesso</div>
		{literal}
		<script type='text/javascript'>
			setTimeout(function(){ 
				$('.success_field').fadeOut(); 
			}, 3000);
		</script>
		{/literal}
	{/if}
	{$fields}
</div>
<script type='text/javascript'>
	{$js_content}
</script>