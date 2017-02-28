	function openBox()
	{
		SsxUpload.uploadDialog('callback_upload', {'token': tk_upload });
	}
	
	$(function()
	{
		$('#tag_complete').tagit({
			afterTagAdded : function(event, ui) {
				tagsAdded.push(ui.tagLabel);
			}
		});

		$('#field_seo_keywords').tagit({
				availableTags:tagsAdded,
		});
		
		$('#imagem_destaque_button').on('click', function()
		{
			SsxUpload.uploadDialog('callback_upload_destaque',{'width':600,'height':200, 'token': tk_upload});
		});
		
		$('#field_title').blur(function()
		{
			var t = $(this).val();
			if(t != "")
			{
				if(!slug_changed)
				{
					title_used = t;
					Ssx.ajax('SsxAjaxPages_generateslug',{'title':title_used, 'token': tk},function(result)
					{
						if(result.success)
						{
							last_slug_used = result.slug;
							$('#slug_display').show();
							$('#field_slug').val(last_slug_used).removeAttr('disabled');		
							
						}
						
						$('#field_slug').removeAttr('disabled');
						$("#loading").addClass('hide');
					}, function(){
						$('#field_slug').removeAttr('disabled');
						$("#loading").addClass('hide');
					});
					$('#field_slug').attr('disabled', 'disabled');
					$("#loading").removeClass('hide');
				}
			}
		});

		$('#field_slug').blur(function(){
			slug_changed = true;

			if($(this).val()== "")
			{
				$(this).val(last_slug_used);
			}
		});


		$('#image_new_media').click(function(){
			SsxUpload.uploadDialog('callback_upload_medias',{'width':800,'height':600,'token': tk_upload});	
		});

		$('.close-list-medias').live('click',function(){
			$(this).parent().remove();
		});

		$('#media_new_video').click(function()
		{
			 $('.item-video').eq(0).clone(true).removeClass('hide').appendTo('#item-video-list');
		});
	});


	function callback_upload(result)
	{
		if(result.success)
		{
			tinymce.execCommand('mceInsertContent',false,'<img width="100%" class="img-responsive" src="'+result.file_url+'" />');
		}else{
			alert("Erro ao fazer UPLOAD do Arquivo!");
		}
	}

	function callback_upload_destaque(result)
	{
		if(result.success)
		{
			$('#featured_image_input').val(result.clean_file_url);
			$('#imagem_destaque_button span').html("Alterar Imagem");
			$('#featured-image').attr('src',result.file_url).removeClass('hide');
		}else
		{
			alert("Erro ao fazer UPLOAD do Arquivo! Tente novamente.");
		}
	}

	function callback_upload_medias(result)
	{
		if(result.success)
		{
			var clone = $('.item-media').eq(0).clone(true);
			clone.removeClass('hide');
			clone.find('img').attr('src',result.file_url);
			clone.find('input').val(result.clean_file_url);
			clone.appendTo('#item-media-list');
		}else{
			alert("Erro ao fazer UPLOAD do Arquivo! Tente novamente.");
		}
	}