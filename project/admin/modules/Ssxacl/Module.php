<?php
/**
 * Modulo de controle de permissões do sistema
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 
 $locale = new SsxModulesLocale();
 
 $locale->plural = "Permissões de Acesso";
 $locale->singular = "Permissão de Acesso";
 $locale->edit = "Editar Permissões";
 
 Ssx::$themes->setModuleLocale($locale);
 
 // 404 error só pode ser marcado pelo arquivo principal do modulo
 if(Ssx::$themes->is_404())
 {
 	// marca a chamada do template 404.tpl
 	Ssx::$themes->set_404_action(false);
 	
 }
