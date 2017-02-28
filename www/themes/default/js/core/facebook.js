function SsxFacebook(_appId,_channelUrl)
{
	this.appID = _appId;
	this.channelUrl = _channelUrl;
	this.aToken; 
	
	this.init = function()
	{
		var d = document, s = 'script', id = 'facebook-jssdk',
		js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/sdk.js";
	    fjs.parentNode.insertBefore(js, fjs);
	    
	    return this;
	};	
	
	this.fbConfigStart = function()
	{		
		FB.init({
			appId      : this._sfb.appID,
			//channelUrl : this.channelUrl, 
			cookie     : true, 
			xfbml      : true,
			version    : 'v2.1'
		});
		
		FB.getLoginStatus(this._sfb.fbStatusCheckLogin);
	};
	
	this.fbStatusCheckLogin = function(response)
	{
		if (response.status === 'connected') {
		      // Logged into your app and Facebook.
		      //testAPI();
			//if(authResponse)
			
	    } else if (response.status === 'not_authorized') {
	      // The person is logged into Facebook, but not your app.
	      console.log('Please log ' +'into this app.');
	    } else {
	      // The person is not logged into Facebook, so we're not sure if
	      // they are logged into this app or not.
	      console.log('Please log ' +'into Facebook.');
	    }
	};	
	
	this.login = function(scope_content,callback)
	{
		FB.login(function(response) {
			if (response.authResponse)
			{
				this._sfb.aToken = response.authResponse.accessToken;
				FB.api('/me', function(response)
				{
					// Autorização recebida
					callback(response);
				});
			} else {
				// Usuário não autorizou conexão
				callback(false);
			}
		}, {scope: scope_content});
	};
	
	this.adjust = function()
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
	};
	
	this.share = function(name,description,url,picture)
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
					//ga_addClick("Facebook","Compartilhe","Compartilhou");
				} else {
					//ga_addClick("Facebook","Compartilhe","Cancelou");
				}
			}
		);
	};
	
	window.fbAsyncInit = this.fbConfigStart;	
	window._sfb = this.init();
};
