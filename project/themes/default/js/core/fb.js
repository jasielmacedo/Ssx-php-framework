var token;

// Envia imagem do servidor para o Facebook
function sendFBPhoto(album, msg, src, callback)
{
	FB.api('/'+ album +'/photos', 'post', {
		message: msg,
		url: src
	},
	function(response)
	{
		// Envio finalizado
		callback(response.id);
	});
};

function shareDialog(name,description,url,picture)
{
	//trackEvent("Facebook","Compartilhar","Abriu");
	FB.ui(
	{
		method: 'feed',
		name: name,
		link: url,
		picture: picture,
		description: description
		},
		function(response) {
			if (response && response.post_id)
			{
				ga_addClick("Facebook","Compartilhe","Compartilhou");
			} else {
				ga_addClick("Facebook","Compartilhe","Cancelou");
			}
		}
	);
};
// Carrega e redimensiona imagem
function loadFBImage(id, src, maxHeight, maxWidth, callback)
{
	var img = new Image();
	img.onload = function()
	{
		var ratio, size,
		tag = "<img id='"+ id +"' src='"+ this.src +"' width='";
		if(this.width > this.height)
		{
			ratio = this.width / this.height;
			size = Math.ceil(maxHeight * ratio);
			tag += size +"' height='"+ maxHeight +"' style='margin-left:-"+ Math.ceil((size - maxHeight) / 2);
		} else {
			ratio = this.height / this.width;
			size = Math.ceil(maxWidth * ratio);
			tag += maxWidth +"' height='"+ size +"' style='margin-top:-"+ Math.ceil((size - maxWidth) / 2);
		}
		tag += "px' />";
		
		callback(tag);
	};
	img.src = src;
	
}
// Carrega e redimensiona imagem
function loadOpenGraph(id, token, maxHeight, maxWidth, callback)
{
	loadFBImage(id, "https://graph.facebook.com/"+ id +"/picture?access_token="+ token, maxHeight, maxWidth, callback);
}

// Cria álbum para o aplicativo no perfil do Facebook do usuário
function getFBPhotos(id,callback)
{
	FB.api('/'+ id +'/photos', function(response)
	{
		callback(response);
	});
};
// Cria álbum para o aplicativo no perfil do Facebook do usuário
function getFBAlbums(callback)
{
	FB.api('/me/albums', function(response)
	{
		callback(response);
	});
};

// Ajusta Canvas do Facebook
function adjustFBCanvas()
{
	if(FB != undefined && FB.Canvas != undefined)
	{
		var doc;
		if($.browser != undefined)
			doc = !$.browser.msie ? "html,body" : document;
		else
			doc = document;
		FB.Canvas.setSize({ height: $(doc).height() });
		FB.Canvas.scrollTo(0,0);
	}
}

// Conecta usuário ao aplicativo
function connectFBUser(callback,scope_content)
{
	FB.login(function(response) {
		if (response.authResponse)
		{
			token = response.authResponse.accessToken;
			FB.api('/me', function(response)
			{
				// Autorização recebida
				ga_addClick("Facebook","Conexao","Aceitou");
				callback(response);
			});
		} else {
			// Usuário não autorizou conexão
			callback(false);
			ga_addClick("Facebook","Conexao","Recusou");
		}
	}, {scope: scope_content});
};
function initFacebook(callback,app_id,channel_url)
{
	window.fbAsyncInit = function()
	{
		// init the FB JS SDK
		FB.init({
			appId      : app_id, // App ID from the App Dashboard
			channelUrl : channel_url, // Channel File for x-domain communication
			status     : true, // check the login status upon init?
			cookie     : true, // set sessions cookies to allow your server to access the session?
			xfbml      : true  // parse XFBML tags on this page?
		});
		// Additional initialization code such as adding Event Listeners goes here
		callback();
	};
	// Load the SDK's source Asynchronously
	// Note that the debug version is being actively developed and might 
	// contain some type checks that are overly strict. 
	// Please report such bugs using the bugs tool.
	(function(d, debug){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/pt_BR/all" + (debug ? "/debug" : "") + ".js";
		ref.parentNode.insertBefore(js, ref);
	}(document, /*debug*/ false));
};