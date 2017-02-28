<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 
 $plugin_id = Ssx::$request->fromFriendlyUrl(1);
 if($plugin_id == the_action())
 	 $plugin_id = Ssx::$request->fromFriendlyUrl(2);
 
 $SsxPlugins = new SsxPlugins(Ssx::$link);
 
 if(!$plugin_id)
 	header_redirect(get_url(the_module(), 'index'));
 
 $plugin = $SsxPlugins->getPluginByReferenceName($plugin_id);
 
 if(!$plugin)
 	header_redirect(get_url(the_module(), 'index'));
 	
 
 $config_reference = PLUGINPATH . $plugin['reference_name'] . "/config.php";
 $config_template = PLUGINPATH . $plugin['reference_name'] . "/config.tpl";
 
 if(file_exists($config_reference) && file_exists($config_template))
 {
 	 require($config_reference);
 	 
 	 Ssx::$themes->assign('config_tpl',$config_template);
 }