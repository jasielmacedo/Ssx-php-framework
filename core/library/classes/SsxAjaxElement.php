<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

defined("SSX") or die;

/**
 * Classe padrão para todos os elementos ajax que forem colocados em tela
 * As classes precisam ser filhas dela para garantir que não sejam executadas funções de outros locais
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @since 1.3.3
 * @version 1.0
 *
 */
class SsxAjaxElement
{	
	private $inAdmin = false;
	
	public $module = "Home";
	
	public $action = "index";
	
	public $platform = null;
	
	public function __construct(){ $this->super(); }
	public function SsxAjaxElement(){ $this->super(); }
	
	public function super()
	{		
		
		$ad = Ssx::$request->fromPost('ad');
		if($ad && $ad != "false")
		{
			$this->inAdmin = true;
		}
		
		if(null === $this->platform)
			$this->platform = the_platform();
	}
}