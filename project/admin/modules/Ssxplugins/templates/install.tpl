<div class='content'>
	<h2>Instalar {$locale->singular}</h2>
	<div class='text-error'>{$data_error}</div>
</div>
<div class='content'>
   <p>Selecione o arquivo compactado do {$locale->singular} para instalar<br />
   O {$locale->singular} não será instalado caso haja um {$locale->singular} com o mesmo nome<br />
   O nome de referencia do {$locale->singular} é o nome que estiver o arquivo compactado.<br /><br />
   Caso não seja encontrado na raiz do plugin o arquivo manifest.xml, o {$locale->singular} não será instalado.
   </p>
	{$ssx_fields}
</div>
<hr />
<div class='content'>
   <p>Caso já tenha {$locale->plural} na pasta e deseja recupera-los clique aqui:<br />
   <a class="btn btn-info margin_t_10" href="{$siteurl}{$this_module}/{$this_action}?recover=true">Recuperar {$locale->plural} apartir da pasta</a>
   {if $recover}
   	 <div class="alert alert-success">
   	 {if $recover eq "true"}
   	 	Um ou mais {$locale->plural} foram recuperados com sucesso
   	 {else}
   	 	Nenhum {$locale->singular} encontrado para recuperar
   	 {/if}
   	 </div>
   {/if}
<script type='text/javascript'>
	{$ssx_fields_js_content}
</script>