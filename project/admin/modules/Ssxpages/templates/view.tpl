<div class="content">
	<h2>{$locale->singular}: {$view.title}</h2>
	<div class='margin_10 margin_b_20'>
		<dl class="dl-horizontal">
		  <dt>Url:</dt>
		  	<dd><a href='{$projecturl}{$view.slug}' target='_blank'>{$projecturl}{$view.slug}</a></dd>
		  <dt>Título SEO:</dt>
		  	<dd>{$view.seo_title} &nbsp;</dd>
		  <dt>Keywords SEO:</dt>
		  	<dd>{$view.seo_keywords} &nbsp;</dd>
		  <dt>Resumo:</dt>
		  	<dd>{$view.seo_description} &nbsp;</dd>
		  {if $view.tags}
		  <dt>Tags:</dt>
		  	<dd>
		  		{section name=i loop=$view.tags}
		  		<span class='label label-default'>{$view.tags[i].name}</span>
		  		{/section}
		  	</dd>
		  {/if}
		  {if $view.featured_image}
		  <dt>Imagem Destaque:<dt>
		  	<dd><img src='{$projecturl}{$view.featured_image}' width='320' class='padding_10' /></dd>
		  {/if}
		</dl>
	</div>
	<div class='clear margin_t_10'>
	{if $ssxacl.this_module.edit}
    	 <a href="{$siteurl}{$this_module}/edit/{$view.id}" class="btn btn-small btn-success"><i class='icon-pencil'></i> {$locale->edit}</a>
     	{if $view.id neq "1"}
    	 	<a href="javascript:void(0);" class="btn btn-small btn-warning" onclick="checkStatus('{$view.id}', {$view.status})"><i class='icon-warning-sign'></i> {if $view.status eq "1"}Alterar para Rascunho{else}Publicar{/if}</a>
     		<a href="javascript:void(0);" class="btn btn-small btn-danger" onclick="checkDelete('{$view.id}')"><i class='icon-trash'></i> {$locale->delete}</a>
  	 	{/if}
  	{/if}
  	{if $view.status eq "1"}
  	 <a href="{$projecturl}{$view.slug}" target="_blank" class="btn btn-small btn-info"><i class='icon-eye-open'></i> {$locale->view}</a>
  	{/if}
  	</div>
	<hr />
	{$view.content}
</div>
<script type='text/javascript'>
{if $ssxacl.this_module.edit}
 function checkDelete(id)
 {
	 if(confirm("Tem certeza que deseja apagar esse {$locale->singular}?"))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}/{$view.id}?delete=true";
	 }
 }

 function checkStatus(id, status)
 {
	 var msg;

	 if(status)
	 {
		msg = "Tem certeza que deseja desativar esse {$locale->singular}?";
	 }
	 else
	 {
		msg = "Tem certeza que deseja publicar esse {$locale->singular}?";
	 }
	 
	 if(confirm(msg))
	 {
		window.location.href = "{$siteurl}{$this_module}/{$this_action}/{$view.id}?alter_status=true";
	 }
 }
 {/if}
</script>