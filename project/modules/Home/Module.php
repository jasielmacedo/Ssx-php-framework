<?php
/**
 * Arquivo principal do modulo
 * Nao tem contato direto com o view, mas é possível enviar algo para lá,
 * Através daqui
 * 
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 defined("SSX") or die;

 
 Ssx::$themes->set_slug_action('pages');
 
 // 404 error só pode ser marcado pelo arquivo principal do modulo
 if(Ssx::$themes->is_404())
 {
 	// marca a chamada do template 404.tpl
 	Ssx::$themes->set_404_action();
 }

 