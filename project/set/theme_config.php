<?php
/**
 *  Arquivo de configurações do Tema
 *  Caso esse arquivo não exista, o projeto continuará funcionando sem problemas
 *  
 *  Esse arquivo será processado antes do modulo e action
 *  Servirá para acrescentar alguma configuração adicional que servirá para o projeto inteiro
 *  
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.1.0
 */
 
 defined("SSX") or die;


 // declare constantes e use funções de configurações aqui
 
 // caso não haja título configurado por SEO, o sistema substitui
 Ssx::$themes->set_theme_title("Ssx framework | He's alive", true);
 

 load_css("css/bootstrap.min.css");
 load_css("css/bootstrap-theme.min.css");
 
 
 
 