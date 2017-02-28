<form action="" method="post" class='form' role="form">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Publicação</h3>
			  </div>
			  <div class="panel-body">
			  	<div class="form-group">
			  		<label for="status" class='f16'>Status</label>
				    <select name='status' class="form-control">
						<option value='0' {if $edit.status eq "0"}selected="selected"{/if}>Rascunho</option>
						<option value="1" {if $edit.status eq "1"}selected="selected"{/if}>Publicado</option>
					</select>
				</div>
				<input type='submit' class='btn btn-primary right margin_t_10' name='saveValues' value='{if $edit}Atualizar{else}Salvar{/if}' />
			  </div>			  
			</div>
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Imagem representativa</h3>
			  </div>
			  <div class="panel-body">
			  	 
			  	 <img {if $edit.featured_image}src="{$projecturl}/{$edit.featured_image}"{/if} id="featured-image" class="img-responsive {if !$edit.featured_image}hide{/if}" />
			  	 <a href="javascript:void(0);" class='btn btn-small btn-default margin_t_10' id='imagem_destaque_button'><i class='icon-upload'></i> <span>{if $edit.featured_image}Trocar Imagem{else}Selecionar Imagem{/if}</span></a>
			  	 <input type='hidden' id='featured_image_input' name='featured_image' value="{$edit.featured_image}" />
			  </div>			  
			</div>
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Tags</h3>
			  </div>
			  <div class="panel-body">
			  	 <div class="form-group">
				    <input type='text' name="tags" id="tag_complete" value="{$edit.tags}" class='form-control '/>
				</div>
			  </div>			  
			</div>
			<div class="panel panel-warning">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Imagens Adicionais</h3>
			  </div>
			  <div class="panel-body">
			  	 <div id='item-media-list'>
				  	 <div class='item-media hide'>
				  	 	 <button type="button" class="close close-list-medias">&times;</button>
				  	 	 <img src=""  class="img-responsive border_1 border_c_ccc padding_10" />
					  	 <input type='hidden' name='medias[]' value="" />
				  	 </div>
				  	 {section name=i loop=$edit.medias}
					  	 <div class='item-media'>
					  	 	 <button type="button" class="close close-list-medias">&times;</button>
					  	 	 <img src="{$projecturl}/{$edit.medias[i]}"  class="img-responsive border_1 border_c_ccc padding_10" />
						  	 <input type='hidden' name='medias[]' value="{$edit.medias[i]}" />
					  	 </div>
				  	 {/section}
			  	 </div>
			  	 <a href="javascript:void(0);" class='btn btn-small btn-default margin_t_10 ' id='image_new_media'><i class='icon-upload'></i> <span>Adicionar Midia</span></a>
			  </div>			  
			</div>
			<div class="panel panel-warning">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Vídeos Adicionais</h3>
			  </div>
			  <div class="panel-body">
				  	 <div id='item-video-list'>
					  	 <div class='item-video hide margin_t_10'>
						  	 <input type='text' name='videos[]' class='inline' value="" />
						  	 <button type="button" class="close close-list-medias">&times;</button>
					  	 </div>
				  	 	{section name=i loop=$edit.videos}
					  	 <div class='item-video margin_t_10'>
						  	 <input type='text' name='videos[]' class='inline' value="{$edit.videos[i]}" />
						  	 <button type="button" class="close close-list-medias">&times;</button>
					  	 </div>
					  	 {/section}
				  	 </div>
			  	 <a href="javascript:void(0);" class='btn btn-small btn-default margin_t_10 ' id='media_new_video'><i class='icon-upload'></i> <span>Adicionar Vídeo</span></a>
			  	 <span class="help-block">Clique em adicionar e copie o link do youtube ou vimeo.</span>
			  </div>			  
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>{if $edit}{$locale->edit}{else}{$locale->add}{/if} {$locale->singular}</h3>	
			  </div>
			  <div class="panel-body">
			  		{if $data_error}
			  			<div class='alert alert-danger'>{$data_error}</div>
			  		{/if}
		    		<div class="form-group">	 
		    			 <label for="title" class='f16'>Título do {$locale->singular}</label>
		    			 <span class='label label-danger' id='field_title_error'></span>
		    			 <input type='text' name='title' id='field_title' class='form-control required' data-min="4" data-error="#field_title_error" value='{$edit.title}' placeholder="Insira o título" />
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Url do {$locale->singular}:</label>
		    			 <span class='label label-danger' id='field_slug_error'></span>
		    			 <div class="input-group">
		    			 	 <div class="input-group-addon">{$projecturl}</div>
		    			 	 <input type='text' name='slug' id='field_slug' class='form-control required'  data-min="4" data-error="#field_slug_error" value='{$edit.slug}' placeholder="Insira ou altere a url" />
		    			 	 <div class="input-group-addon hide" id="loading"><img src="{$image_url}loader.gif" /></div>
		    			 </div>		    			 
		    		</div>
		    		<a href="javascript:void(0);" class='btn btn-small btn-default' onclick="openBox()"><i class='icon-camera'></i></a>
		    		<div class='margin_l_15 margin_r_15 table-responsive'>
			    		<div class="row">
			    			{$ssx_editor}
			    		</div>
		    		</div>
			  </div>			  
			</div>
			<div class="panel panel-success">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>SEO da Página</h3>	
			  </div>
			  <div class="panel-body">
		  			<div class="form-group">
		    			 <label for="title" class='f16'>Título SEO do {$locale->singular}</label>
		    			 <input type='text' name='seo_title' id='field_seo_title' class='form-control' value='{$edit.seo_title}' placeholder="Insira o título SEO" />
		    			 <span class="help-block">Caso não informado, será utilizado o "título do {$locale->singular}".</span>
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Keywords do Projeto</label>
		    			 <input type='text' name="seo_keywords" id='field_seo_keywords' class='form-control' value='{$edit.seo_keywords}' placeholder="Insira as Keywords separadas por vírgula" />
		    			  <span class="help-block">Caso não informado, será utilizado as "tags" do {$locale->singular}.</span>
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Resumo/Descrição do {$locale->singular}</label>
		    			 <textarea name="seo_description" id='field_seo_description' class='form-control'>{$edit.seo_description}</textarea>
		    		</div>
			  </div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">

	$('#slug_display').hide();
	
	var slug_changed = {if $edit.slug neq ""}true{else}false{/if};
	var title_used = "{$edit.title}";
	var last_slug_used = "{$edit.slug}";
	var tk = "{$ajax_token}";
	var tk_upload = "{$token_upload}";
	var tagsAdded = [];


	{$js_content}
</script>
