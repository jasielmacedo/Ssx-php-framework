<div class='content well'>
	<h3>{if $edit}{$locale->edit}{else}{$locale->add}{/if}</h3>
	<div class='text-error'>{$data_error}</div>
	{$fields}
</div>
<script type='text/javascript'>
	{$js_content}
</script>