<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */
 // obrigatorio definir LOCALPATH como local de inicio de tudo
 
 $start = microtime(true);

 define( 'LOCALPATH',   realpath(dirname(__FILE__) . "/../project") . '/' );
 define( 'LOCALLOWPATH', dirname(__FILE__) . '/' );

 include_once(LOCALPATH . "../core/core.php");

 
 // fecha conexão com banco
 Ssx::shutDown();
