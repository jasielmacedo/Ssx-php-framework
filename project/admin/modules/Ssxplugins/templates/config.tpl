{if $config_tpl}
	{include file=$config_tpl}
{else}
   <h2 class="module_title">Configurações do plugin</h2>
   <p>
   		Arquivo para configurações do plugin não encontrado.
   		<br />
   		<a href="{$siteurl}{$this_module}/index">voltar</a>
   </p>
{/if}