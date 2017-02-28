<?php
/**
 *  Arquivo de inicialização do Ssx
 *   
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.2.0
 *  @since 09/01/2011
 *  
 *  Todos os arquivos dentro da pasta CORE, são de propriedade
 *  da Skyjaz Games
 *  skyjaz.com
 *  
 */

  set_time_limit(0);
  
  /* Session start and set config session */
  session_name('SSID');

  
  if(count(get_included_files())<1)
  	die("PONTO DE ENTRADA INVALIDO");
 

  if(!defined('COREPATH'))
 	 define( 'COREPATH', __DIR__ . '/' );
 	 
  if(!defined('LOCALPATH'))
  	 define('LOCALPATH', COREPATH );
  
  if(!defined('LOCALLOWPATH'))
  	die("Defina LOCALLOWPATH para continuar.");
  
  define( 'SSX', 'secure' );
  
  include_once( COREPATH . "library/brain/Ssx.php");
  
  /**
   * Inicia o Ssx
   */
  Ssx::initialize();
  
  