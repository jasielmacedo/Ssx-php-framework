<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

  $locale = new SsxModulesLocale();
	
  $locale->plural = "Páginas";
  $locale->singular = "Página";
	
  Ssx::$themes->setModuleLocale($locale);

  $pages_visible = SsxConfig::get(SsxConfig::SSX_PAGES_ALLOW);
  
  if(!$pages_visible)
  {
  	  Ssx::$themes->assign('allow_error',true);
  }