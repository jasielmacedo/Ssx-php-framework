<?php
/**
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

Ssx::$themes->set_theme_title('| Chamados', false);

// 404 error só pode ser marcado pelo arquivo principal do modulo
if(Ssx::$themes->is_404())
{
	// marca a chamada do template 404.tpl
	Ssx::$themes->set_404_action(false);

}


$locale = new SsxModulesLocale();

$locale->plural = "Chamados";
$locale->singular = "Chamado";
$locale->add = "Abrir novo chamado";

Ssx::$themes->setModuleLocale($locale);