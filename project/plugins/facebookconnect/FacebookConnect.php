<?php 
/**
 * Plugin de conexão com o facebook
 * 
 * Usa classe SsxFacebook para fazer as configurações do plugin
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @since 26/07/2012
 * @version 1.0
 * @uses SsxFacebook
 * 
 */

define( 'FB_PLUGIN_PATH', dirname(__FILE__) . '/' );

/**
 * @return void
 */
function facebookconnect_init()
{	
	if(!defined('IS_ADMIN') || !IS_ADMIN)
	{
		//SsxActivity::addListener(SsxActivity::SSX_THEME_BEFORE_CONFIG_LOADED, 'facebookconnect_open');
	}
}

function facebookconnect_open()
{	
	$params = SsxConfig::get('_facebook_connect_params','json');
	
	if($params && is_array($params))
	{
		if($params['active'])
		{
			// abre a conexão com o facebook
			
			$args = array(
					'appId' 	=> $params['app_id'], 
					'secret' 	=> $params['app_secret']
			  );
			
			/*
			 * @todo Necessário refazer.
			 * 
			require FB_PLUGIN_PATH . "FacebookApi.php";
			 
			 $FacebookApi = new FacebookApi($args);
			 
			 $Ssx->FACEBOOK_URL = $params['facebook_url'];
			 
			 $valid = $FacebookApi->getPermissions();
			 
			 if($params['require_perm'])
			 {
			     if(!$valid)
				 {
				 	  $url = $SsxFacebook->permissionsUrl($params['scope'],$params['facebook_url']);
				 	  if(!defined('IS_AJAX') || !IS_AJAX)
				 	     redirect($url, true);
				 }
			 }*/
		}
	}
}