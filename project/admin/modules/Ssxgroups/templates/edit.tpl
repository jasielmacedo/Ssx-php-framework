<div class='content well'>
	<h2>{if $edit}{$locale->edit}{else}{$locale->add}{/if}</h2>
	{if $data_error}
		<div class='alert alert-danger'>{$data_error}</div>
	{/if}
	{$fields}
</div>
<script type='text/javascript'>
	{$js_content}
</script>