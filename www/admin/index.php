<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.1.0
 */
 

 // obrigatorio definir LOCALPATH como local de inicio de tudo
 define( 'LOCALPATH',   realpath(dirname(__FILE__) . "/../../project/admin") . '/' );
 define( 'LOCALLOWPATH', dirname(__FILE__) . '/' );
 define( 'PROJECTLOWPATH',realpath(constant("LOCALLOWPATH") . "../")."/");
 
 /* se o server não suportar, remova esta opção */
 define('FORCE_HTTPS', false);
 
 // define que se trata de um admin
 define('IS_ADMIN', true);
 
 include_once(LOCALPATH . "../../../ssx/core/core.php");

 Ssx::shutDown();
