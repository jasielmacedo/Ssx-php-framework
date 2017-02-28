function SsxUploadJs()
{
	this.uploadBoxOpen = false;
	
	this.ajaxUpload = function(form, function_to_call ,callback)
	{
		if(!Ssx.jqueryLoaded())
		{
			console.log('Ssx Ajax: Jquery not found');
			return false;
		}
		
		if(!__JQUERY_FORM__)
		{
			console.log('Ssx Ajax: jquery form not found');
			return false;
		}
		
		if(Ssx.isNull(function_to_call))
		{
			console.log("Ssx Ajax Error: function to call is null");
			return false;
		}
		
		var dataToSend = {
			'function_call' : function_to_call,
			'function_callback' : callback,
			'output' : 'json',
			'ad' : (ad)?true:false
		};
		
		var options = {
				'data':dataToSend,
				'url': _ssx_siteurl,
				'dataType':'json',
				'uploadProgress': function(event, position, total, percentComplete) 
				{
			        var percentVal = percentComplete + '%';
			        $('#ssx_dialog_upload_progress_status .progress-bar').attr("style","width: "+percentVal+"%");
			       
			    },
			    'complete':function()
			    {
			    	 $('#ssx_dialog_upload_progress_status .progress-bar').attr("style","width: 100%");
			    	 $('#ssx_dialog_upload').modal('hide');
			    },
				'success': function(data) 
				{
			    	if(data.errors)
					{
					    console.log(data.errors);
					    return;
					}
					if(data.callback)
					{
						var me = window;
						
						if(navigator.appName.indexOf("Microsoft") != -1)
						{
							me = document;
						}
						
						if(typeof me[data.callback] == 'function')
							me[data.callback](data.result);
						else
							console.log('Ssx Ajax: function callback not exists.');
					}
					
					
				}
		};
		$(form).ajaxSubmit(options);
		return false;
	};
	
	this.uploadDialogCallback = "";
	
	this.uploadDialog = function(callback, options)
	{
		if(!Ssx.jqueryLoaded())
		{
			console.log('Ssx Ajax: Jquery not found');
			return false;
		}
		
		if(!__JQUERY_FORM__)
		{
			console.log('Ssx Ajax: jquery form not found');
			return false;
		}
		
		this.uploadDialogCallback = callback;
		
		$('body').prepend(boxDialog);

		if($('#ssx_dialog_upload').length < 1)
		{
			var boxDialog = "" +
					"<div id='ssx_dialog_upload' class='modal fade' tabindex='-1' role='dialog' aria-hidden='true'>" +
					  "<div class='modal-dialog'>"+
					    "<div class='modal-content'>"+
							"<div class='modal-header'>"+
					    		"<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>"+
					    		"<h3 class='modal-title'>Upload de Imagem</h3>"+
					    	"</div>"+
					    	"<div class='modal-body'>"+
								"<form id='ssx_dialog_upload_form' action='"+_ssx_siteurl+"' method='post' enctype='multipart/form-data'>" +
									"<h2 class='module_title'></h2>" +
									"Selecione uma imagem do seu computador:" +
									"<input type='file' name='ssx_upload_item' id='ssx_upload_item' />" +
									"<input type='hidden' name='item_width' id='ssx_upload_item_width' />" +
									"<input type='hidden' name='item_height' id='ssx_upload_item_height' />" +
									"<input type='hidden' name='token' id='ssx_upload_token' />" +
									"<input type='hidden' name='item_quality' id='ssx_upload_item_quality' />" +
									"<div class='progress margin_t_10' id='ssx_dialog_upload_progress_status'>"+
									  "<span class='progress-bar progress-bar-info' style='width: 0%;'></span>"+
									"</div>"+
								"</form>" +
							"</div>"+
							"<div class='modal-footer'>"+
								"<button id='ssx_dialog_upload_buttom' class='btn btn-small btn-primary'>Upload</button>"+
							"</div>"+
						"</div>"+
					  "</div>"+
					"</div>";
			
			$('body').prepend(boxDialog);
			
			$('#ssx_dialog_upload_buttom').live('click', function()
					{
						if($('#ssx_upload_item').val() == "")
						{
							alert('Selecione um arquivo do seu computador');
							return false;
						}
						$('#ssx_dialog_upload').submit();
					});
			
			$('#ssx_dialog_upload').live('submit', function()
					{
						$('#ssx_dialog_upload_buttom').hide();
						$('#ssx_upload_item').hide();
						$('#ssx_dialog_close').hide();
						SsxUpload.ajaxUpload('#ssx_dialog_upload_form','SsxAjaxUpload_uploadFile','ssx_upload_image_callback');
						return false;
					});
		}
		$('#ssx_upload_item').show();
		$("#ssx_upload_item").val("");
		$('#ssx_dialog_upload_buttom').show();		
		$('#ssx_dialog_upload').modal('show');
		$('#ssx_dialog_upload_progress_status .progress-bar').attr("style","width: 0%");
		
		$('#ssx_upload_item_width').val("");
		$('#ssx_upload_item_height').val("");
		$('#ssx_upload_item_quality').val("");
		
		if(options != undefined)
		{
			if(options.width != undefined && options.width)
				$('#ssx_upload_item_width').val(options.width);
			
			if(options.height != undefined && options.height)
				$('#ssx_upload_item_height').val(options.height);
			
			if(options.quality != undefined && options.quality)
				$('#ssx_upload_item_quality').val(options.quality);
			
			if(options.token != undefined && options.token)
				$('#ssx_upload_token').val(options.token);
		}
		
		
		//var screenWidth = $(window).width();
		//var screenHeight = $(window).height();
		
		//$('#ssx_dialog_upload').css({'top': (screenHeight/2 - 100/2)-150, 'left':(screenWidth/2 - 300/2)})

	};
}

var SsxUpload = new SsxUploadJs();

//off callback
function ssx_upload_image_callback(result)
{
	if(SsxUpload.uploadDialogCallback)
	{
		if(typeof window[SsxUpload.uploadDialogCallback] == 'function')
			window[SsxUpload.uploadDialogCallback](result);
		else
			console.log('Ssx Ajax: function callback not exists.');
	}
}