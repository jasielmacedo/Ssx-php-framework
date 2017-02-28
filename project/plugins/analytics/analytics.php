<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


global $analytics_config;

function analytics_init()
{
	if(!defined('IS_ADMIN') || !IS_ADMIN)
	{
		SsxActivity::addListener(SsxActivity::SSX_HEAD, 'analytics_addCode');
	}else{
		SsxActivity::addListener('ssx_project_edit_args','analytics_project_edit_args');
		SsxActivity::addListener('ssx_project_edit_save','analytics_project_edit_save');
	}
}


function analytics_addCode()
{
	global $analytics_config;
	
	$google_verification = SsxConfig::get("_analytics_google_verification");
	if($google_verification)
	{
		Ssx::$themes->add_head_meta(array('name'=>'google-site-verification','content'=>$google_verification));
	}
	
	$analytics_code = SsxConfig::get("_analytics_code");
	if($analytics_code)
	{
		
		$params = "";
		
		if(isset($analytics_config['page_view']) && $analytics_config['page_view'])
		{
			$params .= "_gaq.push(['_trackPageview', '".$analytics_config['page_view']."']);\n";
		}else{
			$params .= "_gaq.push(['_trackPageview']);\n";
		}
		
		$content = "
			<script type=\"text/javascript\">
				  var _gaq = _gaq || [];
				  _gaq.push(['_setAccount', '".$analytics_code."']);
				  
				  ".$params."  
				
				  (function() {
				    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				  })();	  
				  
				  function ga_addClick(category, action, description)
				  {
				  	  _gaq.push(['_trackEvent', category, action, description]);	
				  	  return true;
				  }	
			</script>
		";
		
		Ssx::$themes->add_head_content($content);
	}
}


function analytics_project_edit_args($args)
{
  $analytics = SsxConfig::get('_analytics_code');
  $webmasters = SsxConfig::get('_analytics_google_verification');
  
  $args['fields'][] = array('field'=>'label_analytics','type'=>'label','label'=>'Configurações do Google Analytics');
  
  $args['fields'][] = array('field'=>'_analytics_code', 'type'=>'text', 'label'=>'Codigo do Google Analytics', 'value'=>$analytics);
  $args['fields'][] = array('field'=>'_analytics_google_verification', 'type'=>'text', 'label'=>'Codigo do google webmasters','value'=>$webmasters);
  
  return $args;
}

function analytics_project_edit_save($data_request)
{
	SsxConfig::set('_analytics_code',$data_request['_analytics_code'],true);
  	SsxConfig::set('_analytics_google_verification',$data_request['_analytics_google_verification'],true);
}

function analytics_setPageView($page)
{
	global $analytics_config;
	
	$analytics_config['page_view'] = $page;
}