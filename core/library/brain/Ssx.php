<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class Ssx
{
	/**
	 * Item de conexão de banco de dados que será
	 * partilhado em todos as classes que acessarem o banco de dados
	 * 
	 * @var SsxDatabase
	 */
	public static $link;
	/**
	 * Contem o controlador geral do tema do projeto
	 * @var SsxModules
	 */
	public static $themes;
	
	/**
	 * Ativado apenas quando framework esta em modo ajax
	 * @var SsxAjax
	 */
	public static $ajax;
	
	/**
	 * Utilitarios gerais do sistema
	 * @var SsxUtils
	 */
	public static $utils;
	
	/**
	 * Utilitario de coleta de dados enviados pelo usuario
	 * @var SsxRequest
	 */
	public static $request;
	
	/**
	 * Utilitario de controle de Headers de Saída
	 * @var SsxResponse
	 */
	public static $response;
	
	/**
	 * Objeto de criação de log de sessão para registros futuros.
	 * @var SsxSessionLog
	 */
	public static $session_log;
	
	/**
	 * Controle de plugins
	 * @var SsxPlugins
	 */
	public static $plugins;	
	
		
	
	public static function initialize()
	{				
		new Ssx();
	}
	
	public function __construct()
	{
		if((defined('LOCKED') && LOCKED) || count(get_included_files())!= 3)
			die("PONTO DE ENTRADA INVALIDO");
		else
			define('LOCKED', true);
		
		$this->load();
	}
	
	/**
	 * Id do Projeto que o Ssx esta administrando
	 * @var int
	 */
	public static $project = 1;
	
	/**
	 * Dados importantes do projeto
	 * @var SsxProjectData
	 */
	public static $project_data;
	
	/**
	 * Project languages
	 * @var array
	 */
	public static $languages = array('br');
	
	/**
	 * Project locale memory save items
	 * @var SsxLanguage
	 */
	public static $locale;
	
	/**
	 * Itens de inicialização do sistema de conexão com banco de dados
	 */
	
	/**
	 * Array de SsxDbConfig
	 * @var array
	 */
	private $ssx_db_access;
	
	private function load()
	{
		  error_reporting(E_ALL);
		  
		  define('SSX_VERSION', '2.0.2');
		  define('RESOURCEPATH', COREPATH . "resources/");
		  define('LIBPATH', COREPATH . "library/");
		  define('INCLUDEPATH', COREPATH . "includes/");
		  
		  
		  if(defined('IS_ADMIN') && IS_ADMIN)
		  {
		  	  if(!defined("PROJECTPATH"))
		  	  	define('PROJECTPATH', realpath(LOCALPATH . "../") . "/");	  	  
		  }else if(constant('LOCALPATH') == constant('COREPATH'))
		  {
		  	  if(!defined("PROJECTPATH"))
		  	  	define('PROJECTPATH', realpath(LOCALPATH . "../") . "/");	  
		  }else
		  {
		  	  if(!defined("PROJECTPATH"))
		  	  	define('PROJECTPATH', LOCALPATH);
		  }
		  
		  if(!defined("PROJECTLOWPATH"))
		  	define('PROJECTLOWPATH', LOCALLOWPATH);
		  
		  define('CONFIGPATH', realpath(PROJECTPATH . "set/") . "/");
		  
		  if(!defined('ADMIN_FOLDER'))
		  	define('ADMIN_FOLDER','admin');
		  
		  
		  // arquivo de funções gerais do sistema
		  if(!file_exists(INCLUDEPATH . "helpers.php"))
		  	die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA: helpers.php");
		  require_once(INCLUDEPATH . "helpers.php");
		  
		
		  // arquivo de erros comuns no sistema
		  if(!file_exists(INCLUDEPATH . "errors.php"))
			  die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA: errors.php");
		  require_once(INCLUDEPATH . "errors.php");
		  
		  
		  // arquivo de configurações de banco de dados
		  if(file_exists(CONFIGPATH . "config_set.php"))
		  {
		  	 require_once(CONFIGPATH . "config_set.php");
		  }else if(file_exists(LOCALPATH . "set/config_set.php"))
		  {
		  	 require_once(LOCALPATH . "set/config_set.php");
		  }else if(file_exists(PROJECTPATH . ADMIN_FOLDER . "/set/config_set.php"))
		  {
		  	 require_once(PROJECTPATH . ADMIN_FOLDER ."/set/config_set.php");
		  }else
		  {
		  	 die("CONSIST&Ecirc;NCIA DO SISTEMA COMPROMETIDA");
		  }
		  
		  if(defined('ADMIN_ONLY') && ADMIN_ONLY)
		  {
		  	  define('PLUGINPATH', LOCALPATH . "plugins/");
		  }else{
		  	  define('PLUGINPATH', PROJECTPATH . "plugins/");
		  }
		  
		  if(defined('FORCE_HTTPS') && FORCE_HTTPS)
		  {
		  	  if(!is_https())
		  	  {
		  	  	  header_redirect(siteurl(true));
		  	  }
		  }
		  
		  /**
		   * Permite acesso externo atraves de XmlRpcRequest
		   * Definir o dominio para incrementar a segurança.
		   * Porque "*" libera todo tipo de entrada.
		   */
		  
		  
		  
		  spl_autoload_register(array($this,'loadClasses'));
		  
		  // verifica a procedencia dos dados enviados
		  
		  // capture headers request
		  self::$request = new SsxRequest();
		  	
		  // headers response
		  self::$response = new SsxResponse(self::$request->headers, 202);
		  
		  $this->openLink();
		  
		  require_once dirname(__FILE__) . "/SsxRecovery.php";
		  
		  // verifica a consistencia da base
		  SsxRecovery::checkBase();
		  
		  // carrega todas as configs e deixa em cache
		  SsxConfig::loadConfig();
		  
		  
		  
		  // carregando informacoes de admin e guest do projeto
		  $project_data = SsxConfig::get(SsxConfig::SSX_DATA_SET,'serialized');
		  if($project_data)
		  	Ssx::$project_data = &$project_data;
		  else 
		  {
		  	// configuracao default
		  	Ssx::$project_data = new SsxProjectData();
		  	Ssx::$project_data->ad_id = 1;
		  	Ssx::$project_data->ad_g_id = 1;
		  	Ssx::$project_data->g_id = 2;
		  	Ssx::$project_data->g_g_id = 2;
		  }
		  
		  require_once dirname(__FILE__) . "/SsxModules.php";
		   
		  
		  
		  check_request_origin();
		  
		  self::$themes  = new SsxModules();
		  self::$utils   = new SsxUtils();
		  self::$plugins = new SsxPlugins(Ssx::$link);
		  self::$session_log = new SsxSessionLog();		
		  self::$locale = new SsxLanguage();


		  
		  // Start Session
		  SsxSession::start();
		  
		  // inicia o controle de acl geral do sistema
		  $this->startAcl();
		  
		 // inicia todos os plugins instalados do sistema
		  self::$plugins->startPlugins();
		  
		 // load em todo o conteúdo de modulos
		  self::$themes->startThemeConfig();
		  
		  // load sistema de linguagem se houver
		  self::$locale->load();
		  
		  
	}
	
	private function openLink()
	{
		// localiza o ambiente para decisao de banco
		$env = @getenv('APPLICATION_ENV');
		if(!$env)
			$env = "development";
		
		if(!isset($this->ssx_db_access[$env]) || !is_a($this->ssx_db_access[$env], 'SsxDbConfig'))
			die("SSX ERROR: N&atilde;o h&aacute; dados de DB configurado para o ambiente informado. ENV: ".$env);
		
		
		
		if(!$this->ssx_db_access[$env]->ssx_db_host || !$this->ssx_db_access[$env]->ssx_db_type)
		{
			die(SSX_ERROR_CORE_03);
		}
		
		require_once dirname(__FILE__) . "/SsxHosts.php";
		
		$Hosts = new SsxHosts($this->ssx_db_access[$env]->ssx_db_user, $this->ssx_db_access[$env]->ssx_db_pass, $this->ssx_db_access[$env]->ssx_db_host, $this->ssx_db_access[$env]->ssx_db_name, $this->ssx_db_access[$env]->ssx_db_type,$this->ssx_db_access[$env]->ssx_db_port, $this->ssx_db_access[$env]->ssx_hash_key);
		
		
		
		$Database = new SsxDatabase($Hosts,false);
		
		// conexão aberta
		Ssx::$link = $Database;
		
		unset($Hosts);
	}
	
	private function loadClasses($class)
	{
		// adaptacao para php5.4 com use directive
		if(strrpos($class, "\\"))
		{
			$class_dir = explode("\\",$class);
			$class_name = end($class_dir);
	
			if(class_exists($class_name))
		  	    return;
	
		  	$dirlist = str_replace("\\","/",$class) . ".php";
	
		  	if(file_exists(COREPATH . "library/classes/".$dirlist))
			  	 require_once(COREPATH . "library/classes/".$dirlist);
			else if(file_exists(LOCALPATH . "control/".$dirlist))
			 	  require_once(LOCALPATH . "control/".$dirlist);
			else if(file_exists(PROJECTPATH . ADMIN_FOLDER . "/control/".$dirlist))
				  require_once(PROJECTPATH . ADMIN_FOLDER . "/control/".$dirlist);
			else if(file_exists(RESOURCEPATH . $dirlist))
				  require_once(RESOURCEPATH . $dirlist);
		 	else if(file_exists(PLUGINPATH . $dirlist))
				  require_once(PLUGINPATH . $dirlist);
				
		}else{
			if(class_exists($class))
		  	    return;
		  	 
		  	 if(file_exists(COREPATH . "library/classes/".$class.".php"))
			  	 require_once(COREPATH . "library/classes/".$class.".php");
			 else if(file_exists(LOCALPATH . "control/".$class.".php"))
			 	  require_once(LOCALPATH . "control/".$class.".php");
			 else if(file_exists(PROJECTPATH . ADMIN_FOLDER . "/control/".$class.".php"))
				  require_once(PROJECTPATH . ADMIN_FOLDER . "/control/".$class.".php");
		     else if(file_exists(LOCALPATH . "../control/".$class.".php"))
				  require_once(LOCALPATH . "../control/".$class.".php");
			 else
			 {
			 	$file = find_file(RESOURCEPATH,strtolower($class).".php");
			 	if($file)
			 		require_once($file);
			    return;	 
			 }
		}
	}
	
	private function startAcl()
	{		
		$SsxUsers = new SsxUsers();
		$SsxAcl = new SsxAcl();
		$SsxGroups = new SsxGroups();
		
		if(!SsxUsers::getUser(true))
		{
			$SsxUsers->auth('guest','123',true,true);
		}
		
		$_session_name = SsxUsers::getSessionName();
		$_session = SsxAuthSession::getSession($_session_name);

		$redirect_url = siteurl() . the_module() . "/" . the_action();
		
		if($_session)
		{	
			$permissions = $SsxAcl->getPermissionByGroup($_session['group_id']);
			
			// Apartir desse momento em qualquer momento da view é possível saber se ela tem permissão ou não
			SsxUsers::setPermission($permissions);		
			$exists = $SsxUsers->fill($_session['user_id']);
			
			if(defined('IS_AJAX') && IS_AJAX)
				return;
			
			if(!$exists)
			{
				SsxAuthSession::dropSession($_session_name);
				
				if(!is_location('auth', 'login'))
				{
					header_redirect(get_url('auth', 'login', array('redirect'=>$redirect_url)));
				}
				return;
			}else{
				$pl = SsxAcl::checkPermissionForLocal(the_platform());
				
				$group_detail = $SsxGroups->fill($_session['group_id']);
				
				if(the_platform() == "admin")
				{					
					if(!$pl || !SsxAcl::checkPermissionForAction('Home', 'index','admin') || $group_detail['level'] == SsxGroups::LEVEL_GUEST)
					{
						if(!is_location('auth', 'login'))
						{
							header_redirect(get_url('auth', 'login',array('redirect'=>$redirect_url)));
						}
					}
				}
			}			
			
		}else
		{
			$guest_id = Ssx::$project_data->g_g_id;
			
			$permissions = $SsxAcl->getPermissionByGroup($guest_id);
			SsxUsers::setPermission($permissions);
			
			if(defined('IS_AJAX') && IS_AJAX)
				return;
			
			$pl = SsxAcl::checkPermissionForLocal(the_platform());
			
			if(the_platform() == "admin")
			{
				if(!is_location('auth', 'login'))
				{
					header_redirect(get_url('auth', 'login',array('redirect'=>$redirect_url)));
				}
			}
			return;
		}
	}
    
    /**
     * Close all conections and send headers and buffers
     */
    public static function shutDown()
    {
    	// display all template data
    	Ssx::$themes->display();
    	
    	// close db connection
    	Ssx::$link->off();
    	
    	// send all headers
    	SSx::$response->send();
    }
}

class SsxDbConfig
{
	public $ssx_db_type = "mysql";
	public $ssx_db_user;
	public $ssx_db_pass;
	public $ssx_db_host;
	public $ssx_db_name;
	
	public $ssx_hash_key;
	public $ssx_hash_session_key;
	public $ssx_db_port = 3306;
}

class SsxProjectData
{
	public $ad_id;
	public $ad_g_id;
	public $g_id;
	public $g_g_id;
}