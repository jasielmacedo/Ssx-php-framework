<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

  Ssx::$themes->ssx_module_locale->plural = "In&iacute;cio";
  
  if(!SsxConfig::get(SsxConfig::SSX_PAGES_ALLOW))
  {
  	  Ssx::$themes->assign('allow_pages',true);
  }
  
   if(!SsxConfig::get(SsxConfig::SSX_DEFAULT_USER_GROUP))
  {
  	  Ssx::$themes->assign('no_group',true);
  }
  