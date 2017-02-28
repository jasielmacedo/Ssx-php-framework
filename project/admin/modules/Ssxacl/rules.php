<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 */

  Ssx::$themes->ssx_module_locale->singular = "Regras de Uso do Projeto";
  
  if(Ssx::$request->fromQuery('saved'))
  	Ssx::$themes->assign('saved', true);
  
  $rules = SsxConfig::get(SsxConfig::SSX_ACL_RULES,'json');
  if($rules)
  	Ssx::$themes->assign('rules', $rules);
  
  if(Ssx::$request->isPost() && Ssx::$request->fromPost('save'))
  {
  		$rules = Ssx::$request->fromPost('rules');
  		
  		if(is_array($rules))
  		{
  			if(isset($rules[0]) && !$rules[0])
  				array_shift($rules);
  			
  			SsxConfig::set(SsxConfig::SSX_ACL_RULES, json_encode($rules));
  		}else{
  			SsxConfig::set(SsxConfig::SSX_ACL_RULES, json_encode(array()));
  		}
  		
  		header_redirect(get_url(the_module(),the_action(),array('saved'=>true)));
  }