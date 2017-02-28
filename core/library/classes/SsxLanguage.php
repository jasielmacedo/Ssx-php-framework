<?php
/**
 * Classe de controle de linguagem do sistema
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

class SsxLanguage
{
	private $context = array();
	
	public function load()
	{
		$locale = Ssx::$themes->ssx_locale;
		
		if(array_search($locale, Ssx::$languages) !== false)
		{
			if(file_exists(CONFIGPATH ."/locale/".$locale.".php"))
			{
				require_once CONFIGPATH ."/locale/".$locale.".php";
			}
		}
	}
	
	public function get($key)
	{
		if(array_key_exists($key,$this->context))
		{
			return $this->context[$key];
		}		
		return false;
	}
	
	public function toScreen()
	{
		return $this->context;
	}
}
