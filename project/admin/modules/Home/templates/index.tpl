<div class="content">
	<p>
		Bem-vindo ao sistema de administração
	</p>
	{if $no_group && $ssxacl.admin.ssxproject.index}
		<div class="alert alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Cuidado!</h4>
		  Não há grupo padrão para novos usuários. Entre em <a href='{$siteurl}ssxproject'>Configurações do Projeto</a> para configurar.
		</div>
	{/if}
	{if $allow_pages && $ssxacl.admin.ssxproject.index}
		<div class="alert alert-warning">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>Aviso!</h4>
		  A exibição de página estáticas está desabilitada. Entre em <a href='{$siteurl}ssxproject'>Configurações do Projeto</a> e ative caso precise.
		</div>
	{/if}
</div>
