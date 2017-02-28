<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-05-10 23:09:50
         compiled from "E:\dropbox\Dropbox\ssx\project\admin\modules\Ssxpages\templates\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11617573205b3924308-32029228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9391b9bd2ce1e6d06c72035ba17600cd6b296db4' => 
    array (
      0 => 'E:\\dropbox\\Dropbox\\ssx\\project\\admin\\modules\\Ssxpages\\templates\\edit.tpl',
      1 => 1462914588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11617573205b3924308-32029228',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_573205b399d497_89545558',
  'variables' => 
  array (
    'edit' => 0,
    'projecturl' => 0,
    'locale' => 0,
    'data_error' => 0,
    'image_url' => 0,
    'ssx_editor' => 0,
    'ajax_token' => 0,
    'token_upload' => 0,
    'js_content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_573205b399d497_89545558')) {function content_573205b399d497_89545558($_smarty_tpl) {?><form action="" method="post" class='form' role="form">
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
						<option value='0' <?php if ($_smarty_tpl->tpl_vars['edit']->value['status']=="0") {?>selected="selected"<?php }?>>Rascunho</option>
						<option value="1" <?php if ($_smarty_tpl->tpl_vars['edit']->value['status']=="1") {?>selected="selected"<?php }?>>Publicado</option>
					</select>
				</div>
				<input type='submit' class='btn btn-primary right margin_t_10' name='saveValues' value='<?php if ($_smarty_tpl->tpl_vars['edit']->value) {?>Atualizar<?php } else { ?>Salvar<?php }?>' />
			  </div>			  
			</div>
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Imagem representativa</h3>
			  </div>
			  <div class="panel-body">
			  	 
			  	 <img <?php if ($_smarty_tpl->tpl_vars['edit']->value['featured_image']) {?>src="<?php echo $_smarty_tpl->tpl_vars['projecturl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['edit']->value['featured_image'];?>
"<?php }?> id="featured-image" class="img-responsive <?php if (!$_smarty_tpl->tpl_vars['edit']->value['featured_image']) {?>hide<?php }?>" />
			  	 <a href="javascript:void(0);" class='btn btn-small btn-default margin_t_10' id='imagem_destaque_button'><i class='icon-upload'></i> <span><?php if ($_smarty_tpl->tpl_vars['edit']->value['featured_image']) {?>Trocar Imagem<?php } else { ?>Selecionar Imagem<?php }?></span></a>
			  	 <input type='hidden' id='featured_image_input' name='featured_image' value="<?php echo $_smarty_tpl->tpl_vars['edit']->value['featured_image'];?>
" />
			  </div>			  
			</div>
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'>Tags</h3>
			  </div>
			  <div class="panel-body">
			  	 <div class="form-group">
				    <input type='text' name="tags" id="tag_complete" value="<?php echo $_smarty_tpl->tpl_vars['edit']->value['tags'];?>
" class='form-control '/>
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
				  	 <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['edit']->value['medias']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
					  	 <div class='item-media'>
					  	 	 <button type="button" class="close close-list-medias">&times;</button>
					  	 	 <img src="<?php echo $_smarty_tpl->tpl_vars['projecturl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['edit']->value['medias'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
"  class="img-responsive border_1 border_c_ccc padding_10" />
						  	 <input type='hidden' name='medias[]' value="<?php echo $_smarty_tpl->tpl_vars['edit']->value['medias'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
" />
					  	 </div>
				  	 <?php endfor; endif; ?>
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
				  	 	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['edit']->value['videos']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
					  	 <div class='item-video margin_t_10'>
						  	 <input type='text' name='videos[]' class='inline' value="<?php echo $_smarty_tpl->tpl_vars['edit']->value['videos'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']];?>
" />
						  	 <button type="button" class="close close-list-medias">&times;</button>
					  	 </div>
					  	 <?php endfor; endif; ?>
				  	 </div>
			  	 <a href="javascript:void(0);" class='btn btn-small btn-default margin_t_10 ' id='media_new_video'><i class='icon-upload'></i> <span>Adicionar Vídeo</span></a>
			  	 <span class="help-block">Clique em adicionar e copie o link do youtube ou vimeo.</span>
			  </div>			  
			</div>
		</div>
		<div class="col-md-9">
			<div class="panel panel-info">
			  <div class="panel-heading">
			  	<h3 class='panel-title'><?php if ($_smarty_tpl->tpl_vars['edit']->value) {
echo $_smarty_tpl->tpl_vars['locale']->value->edit;
} else {
echo $_smarty_tpl->tpl_vars['locale']->value->add;
}?> <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</h3>	
			  </div>
			  <div class="panel-body">
			  		<?php if ($_smarty_tpl->tpl_vars['data_error']->value) {?>
			  			<div class='alert alert-danger'><?php echo $_smarty_tpl->tpl_vars['data_error']->value;?>
</div>
			  		<?php }?>
		    		<div class="form-group">	 
		    			 <label for="title" class='f16'>Título do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</label>
		    			 <span class='label label-danger' id='field_title_error'></span>
		    			 <input type='text' name='title' id='field_title' class='form-control required' data-min="4" data-error="#field_title_error" value='<?php echo $_smarty_tpl->tpl_vars['edit']->value['title'];?>
' placeholder="Insira o título" />
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Url do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
:</label>
		    			 <span class='label label-danger' id='field_slug_error'></span>
		    			 <div class="input-group">
		    			 	 <div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['projecturl']->value;?>
</div>
		    			 	 <input type='text' name='slug' id='field_slug' class='form-control required'  data-min="4" data-error="#field_slug_error" value='<?php echo $_smarty_tpl->tpl_vars['edit']->value['slug'];?>
' placeholder="Insira ou altere a url" />
		    			 	 <div class="input-group-addon hide" id="loading"><img src="<?php echo $_smarty_tpl->tpl_vars['image_url']->value;?>
loader.gif" /></div>
		    			 </div>		    			 
		    		</div>
		    		<a href="javascript:void(0);" class='btn btn-small btn-default' onclick="openBox()"><i class='icon-camera'></i></a>
		    		<div class='margin_l_15 margin_r_15 table-responsive'>
			    		<div class="row">
			    			<?php echo $_smarty_tpl->tpl_vars['ssx_editor']->value;?>

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
		    			 <label for="title" class='f16'>Título SEO do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</label>
		    			 <input type='text' name='seo_title' id='field_seo_title' class='form-control' value='<?php echo $_smarty_tpl->tpl_vars['edit']->value['seo_title'];?>
' placeholder="Insira o título SEO" />
		    			 <span class="help-block">Caso não informado, será utilizado o "título do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
".</span>
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Keywords do Projeto</label>
		    			 <input type='text' name="seo_keywords" id='field_seo_keywords' class='form-control' value='<?php echo $_smarty_tpl->tpl_vars['edit']->value['seo_keywords'];?>
' placeholder="Insira as Keywords separadas por vírgula" />
		    			  <span class="help-block">Caso não informado, será utilizado as "tags" do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
.</span>
		    		</div>
		    		<div class="form-group">
		    			 <label for="title" class='f16'>Resumo/Descrição do <?php echo $_smarty_tpl->tpl_vars['locale']->value->singular;?>
</label>
		    			 <textarea name="seo_description" id='field_seo_description' class='form-control'><?php echo $_smarty_tpl->tpl_vars['edit']->value['seo_description'];?>
</textarea>
		    		</div>
			  </div>
			</div>
		</div>
	</div>
</form>
<?php echo '<script'; ?>
 type="text/javascript">

	$('#slug_display').hide();
	
	var slug_changed = <?php if ($_smarty_tpl->tpl_vars['edit']->value['slug']!='') {?>true<?php } else { ?>false<?php }?>;
	var title_used = "<?php echo $_smarty_tpl->tpl_vars['edit']->value['title'];?>
";
	var last_slug_used = "<?php echo $_smarty_tpl->tpl_vars['edit']->value['slug'];?>
";
	var tk = "<?php echo $_smarty_tpl->tpl_vars['ajax_token']->value;?>
";
	var tk_upload = "<?php echo $_smarty_tpl->tpl_vars['token_upload']->value;?>
";
	var tagsAdded = [];


	<?php echo $_smarty_tpl->tpl_vars['js_content']->value;?>

<?php echo '</script'; ?>
>
<?php }} ?>
