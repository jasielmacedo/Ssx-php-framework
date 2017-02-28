<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxModules
{
	/**
	 * Controlador de itens do smarty dentro do tema
	 * @var Smarty
	 */
	public $smarty;
	
	/**
	 * Linguagem geral do sistema
	 * @var string
	 */
	public $ssx_locale;
	
	/**
	 * modulo a ser chamado pelo sistema
	 * @var string
	 */
	public $ssx_module;
	
	/**
	 * action a ser chamada logo a seguir pelo sistema
	 * @var string
	 */
	public $ssx_action;
	
	/**
	 * nome do template da action que vai ser exibido
	 * @var string
	 */
	public $ssx_action_template;
	
	/**
	 * tema do projeto
	 * @var string
	 */
	public $ssx_theme;
	
	/**
	 * locatização de hierarquia de pastas do tema do projeto
	 * @var string
	 */
	public $ssx_theme_path;
	
	/**
	 * url do tema do projeto para a localização do site
	 * @var string
	 */
	public $ssx_theme_url;
	
	/**
	 * Define se o sistema deve considerar o uso e a troca de linguagem
	 * @var boolean
	 */
	public $use_locale = false;
	
	/**
	 * Usado para verificar se o modulo foi iniciado com sucesso
	 * @var boolean
	 */ 
	public $module_found = false;
	
	/**
	 * Usado para verificar se a action foi iniciada com sucesso
	 * @var boolean
	 */ 
	public $action_found = false;
	
	
	/**
	 * Informa se a action foi negada
	 * @var boolean
	 */
	public $action_denied = false;
	/**
	 * url do template que será usado pelo sistema para ser adicionado
	 * @var string
	 */ 
	public $ssx_modules_template = "";
	
	/**
	 * Define se em caso de 404 será direcionado a uma slug
	 * @var boolean
	 */
	private $ssx_use_slug_action = false;
	
	/**
	 * Noma da action que será usada para receber a slug
	 * @var string
	 */
	private $ssx_slug_action = "";
	
	/**
	 * define o .tpl que será exibido como principal
	 * @var string
	 */
	private $ssx_display;
	
	/**
	 * Define dados padrões do Modulo
	 * @var SsxModulesLocale
	 */
	public $ssx_module_locale;
	
	/**
	 * parametros de URL
	 * @var string
	 */
	private $params;
	
	/**
	 * define o conteudo padrao de configuracao que ira no header
	 * como css, js e afins
	 * 
	 * @var array
	 */ 
	private $ssx_head = array();
	
	/**
	 * define meta tags que sero enviadas para o tema
	 * @var array
	 */
	private $ssx_head_meta = array();
	
	/**
	 *  controle de titulo do tema
	 * @var string
	 */
	private $__ssx_theme_title = "Title";
	
	/**
	 * Define que o header nao será exibido, caso haja uma condição no tema para isso
	 * @var boolean
	 */
	private $_disable_header = false;
	
	/**
	 * Define que o footer nao será exibido, caso haja uma condição no tema para isso
	 * @var boolean
	 */
	private $_disable_footer = false;

	public function SsxModules()
	{		
		require_once(RESOURCEPATH . "smarty/libs/Smarty.class.php");
		
		$this->smarty = new Smarty;    
		
		if(defined('CACHED') && CACHED)
			$this->smarty->caching = true;
		
		//Pasta padrão de templates
		$this->smarty->template_dir = "templates";
		//Pasta de templates compilados
		$this->smarty->compile_dir = COREPATH . "storage/cache";
		//Pasta de cache 
		$this->smarty->cache_dir = COREPATH . "storage/cache";   
	      
		//Ativa uso de cache
		$this->smarty->cache_modified_check="true";
		//15 dias para manter o cache
		$this->smarty->cache_lifetime=60*60*24*15; // 15 dias
		
		$this->smarty->error_reporting = E_ERROR;
		
		$this->startVisual();
	}
	
	/**
	 * Inicia todo o sistema de carregamento de modulos e visualização 
	 */
	public function startVisual()
	{
		if(defined('IS_AJAX'))
		   return;

		
		$_theme = constant('SSX_THEME');
		
		if(defined('IS_ADMIN') && IS_ADMIN)
		{
			// marca o tema para o admin com default
			// TODO: Deixar alteravel esse valor, sem precisar mexer na core	
			$_theme = "default";
			
		}
		
		$this->ssx_theme_path = LOCALPATH . "themes/".$_theme;
		$this->ssx_theme_url = siteurl() . "themes/".$_theme;
		$this->ssx_theme = $_theme;
		
		
		$key_to_module = 0;
		$key_to_action = 1;
		
		
		if(defined('SSX_LANGUAGES') && SSX_LANGUAGES)
		{
			if(!defined("IS_ADMIN") || !IS_ADMIN)
			{
				$locale = Ssx::$request->fromFriendlyUrl(0);
				
				if(@array_search($locale,Ssx::$languages) !== false)
				{
					$key_to_module = 1;
					$key_to_action = 2;
					
					$this->ssx_locale = $locale;
					$this->use_locale = true;
				}
			}
		}
		
		if(!$this->ssx_locale)
		{
			$this->ssx_locale = defined('SSX_LANGUAGES_DEFAULT') && SSX_LANGUAGES_DEFAULT?constant('SSX_LANGUAGES_DEFAULT'):"br";
		}
		
		// pega os parametros da URL
		$module = Ssx::$request->fromFriendlyUrl($key_to_module);
		$action = Ssx::$request->fromFriendlyUrl($key_to_action);
				
		// obriga o modulo ter a primeira letra maiuscula
		$module = ucfirst($module);
		
		
		
		// Inicia o arquivo principal do modulo
		if((!file_exists(LOCALPATH . "modules/".$module."/") || empty($module)))
		   $module = "Home";

		
		// segunda verificação para ter certeza que o modulo Home existe
		if(!file_exists(LOCALPATH . "modules/".$module."/")) 
			die(SSX_ERROR_MODULES_01);

		$this->module_found	= true;
		
		$this->ssx_module = $module;	
		
		
		
		if($module == "Home" && strtolower(Ssx::$request->fromFriendlyUrl($key_to_module)) != "home")
		   $action = Ssx::$request->fromFriendlyUrl($key_to_module);
		   
		if(empty($action)) $action = "index";
		
		if(file_exists(LOCALPATH . "modules/".$module."/".$action.".php")){
			$this->action_found = true;
		}else
			$this->action_found = false;
			
		
		
		if($this->action_found)
		{
			$this->ssx_action = $action;
			$this->ssx_action_template = $action;
		}
		
		
		
		if(!file_exists($this->ssx_theme_path ."/". $this->ssx_theme . ".tpl"))
			die(SSX_ERROR_MODULES_02 . "<br />".$this->ssx_theme." : '".$this->ssx_theme.".tpl'");
		$this->ssx_display = $this->ssx_theme_path ."/". $this->ssx_theme . ".tpl";
		
		SsxActivity::dispatchActivity('ssx_start_visual');
		
		// project SEO
		SsxActivity::addListener(SsxActivity::SSX_THEME_CONFIG_LOADED,array($this,'project_seo'));
	}
	
	/**
	 * Inicia o sistema de modules e views do ssx
	 * @return void
	 */
	public function startThemeConfig()
	{
		  SsxActivity::dispatchActivity(SsxActivity::SSX_THEME_BEFORE_CONFIG_LOADED);	
	  
		  // verifica se o arquivo de funções do projeto
		  if(file_exists(LOCALPATH . "set/functions.php"))
		      include(LOCALPATH . "set/functions.php");
		  elseif(file_exists(COREPATH . "../set/functions.php") && defined('IS_AJAX') && IS_AJAX)
		  	  include(COREPATH . "../set/functions.php");
		
		  // verifica se o arquivo de configurações fixas do projeto existe
		  if(file_exists(LOCALPATH . "set/theme_config.php"))
		      include(LOCALPATH . "set/theme_config.php");
		  elseif(file_exists(COREPATH . "../set/theme_config.php") && defined('IS_AJAX') && IS_AJAX)
		  	  include(COREPATH . "../set/theme_config.php");		  	  
		  
		  	  
		  SsxActivity::dispatchActivity(SsxActivity::SSX_THEME_CONFIG_LOADED);	  
		  // se caso tiver marcado como ajax, não será carregado nenhum módulo
		  if(!defined('IS_AJAX'))
		  {
		  	  if(defined('NO_RENDER') && NO_RENDER)
		  	  	return;
		  	
		  	  $redirect_url = siteurl() . the_module() . "/" . the_action();
		  	
		  	  // completando a ação do SsxModules para evitar perca de referencia
		  	  if($this->module_found)
		  	  {
		  	  	  // verifica se o usuário tem permissão para acessar o login
		  	  	  if(!SsxAcl::checkPermissionForModule($this->ssx_module, the_platform()))
		  	  	  {
		  	  	  	  $this->ssx_module = "Home";
		  	  	  	  $this->ssx_action_template = "denied";		  	  	  	  
		  	  	  }else{
		  	  	  	
		  	  	  	  $this->setModuleLocale(new SsxModulesLocale());
			  	  	  // Load no arquivo principal do modulo  	  
			  	  	  if(file_exists(LOCALPATH . "modules/". $this->ssx_module . "/Module.php"))
			  	  	  {	  
			  	  	  	require_once(LOCALPATH . "modules/". $this->ssx_module . "/Module.php");
			  	  	  }
			  	  	  
			  	  	  SsxActivity::dispatchActivity(SsxActivity::SSX_MODULE_LOADED);
			  	  	  
			  	  	  if($this->action_found)
			  	  	  {
			  	  	  	  if(!SsxAcl::checkPermissionForAction($this->ssx_module,$this->ssx_action, the_platform()))
			  	  	  	  {
			  	  	  	  	 $this->ssx_module = "Home";
			  	  	  	  	 $this->ssx_action_template = "denied";
			  	  	  	  	
			  	  	  	  }else
			  	  	  	  {
				  	  	  	  // Load no arquivo secundario, ou seja, da Action
				  	  	  	  require_once(LOCALPATH . "modules/". $this->ssx_module . "/" . $this->ssx_action .".php");
				  	  	  	  
				  	  	  	  if((!defined('NO_RENDER') || !NO_RENDER) && (!defined('IS_AJAX') || !IS_AJAX))
				  	  	  	  {
				  	  	  	  	 if(!file_exists(LOCALPATH . "modules/". $this->ssx_module ."/templates/". $this->ssx_action_template .".tpl"))
									die(SSX_ERROR_MODULES_03. ":" . $this->ssx_action_template.":".$this->ssx_action);
				  	  	  	  }
				  	  	  	  
							  SsxActivity::dispatchActivity(SsxActivity::SSX_ACTION_LOADED);
			  	  	  	  }
			  	  	  }else{
			  	  	  	  $use_slug_action = $this->get_slug_action();
			  	  	  	  if($use_slug_action)
						  {
						  	  $action_replacement = $use_slug_action;
						  	  
						  	  $this->action_found = true;
						  	  $this->ssx_action = $action_replacement;
						  	  $this->ssx_action_template = $action_replacement;
						  	  
						  	  
						  	   if(!SsxAcl::checkPermissionForAction($this->ssx_module,$this->ssx_action, the_platform()))
			  	  	  	  	   {
			  	  	  	  	   		 $this->action_found = false;
			  	  	  	  	   		 $this->disable_slug_action();
			  	  	  	  	   		 $this->set_404_action();
			  	  	  	  	   		 
			  	  	  	  	   }else{
			  	  	  	  	   		  if(file_exists(LOCALPATH . "modules/". $this->ssx_module . "/" . $this->ssx_action .".php"))			  	  
								  	  	 require_once(LOCALPATH . "modules/". $this->ssx_module . "/" . $this->ssx_action .".php");
								  	  else
								  	  	 die(SSX_ERROR_MODULES_06." Action:'".$this->ssx_action."'");
								  	  	 
								  	  if((!defined('NO_RENDER') || !NO_RENDER) && (!defined('IS_AJAX') || !IS_AJAX))
								  	  {
									  	  if(!file_exists(LOCALPATH . "modules/". $this->ssx_module . "/templates/" . $this->ssx_action_template .".tpl"))
									  	  	 die(SSX_ERROR_MODULES_07);
								  	  }
								  	  SsxActivity::dispatchActivity(SsxActivity::SSX_ACTION_LOADED);
			  	  	  	  	   }
						  }else
						  {
						  	  $this->action_found = false;

						  	  if($this->ssx_action_template != "404")
						  	  	$this->set_404_action(false);
						  }
			  	  	  }
		  	  	  }
		  	  }else{
		  	  		// modulo não encontrado
		  	  		$this->action_found = false;
		  	  		$this->disable_slug_action();
		  	  		$this->set_404_action();
		  	  }
		  }else
		  {
		  		 if(SsxAcl::checkPermissionForAction("Home","index",the_platform()))
		  		 {
			  		 /* Area de ajax request */
			  		 $functions_to_call  = Ssx::$request->fromPost('function_call');
					 $ajax_data 		 = Ssx::$request->fromPost('function_data');
					 $function_to_return = Ssx::$request->fromPost('function_callback');
					 
					 $output = (Ssx::$request->fromPost('output'))?Ssx::$request->fromPost('output'):"json";
							 
					 if(!empty($ajax_data) && !is_array($ajax_data)){  $ajax_data = array($ajax_data);}
							
					 require_once COREPATH . "library/brain/SsxAjax.php";
					 
					 $SsxAjax = new SsxAjax($ajax_data, $functions_to_call,$function_to_return, $output);
					 $SsxAjax->returnCall();
		  		 }else{
		  		 	 define_403();
		  		 }
		  }
	}
	
	/**
	 * Marca uma action para exibir o erro 404
	 * @param string $this_module
	 */
	public function set_404_action($this_module=true)
	{
		if($this->is_404())
		{
			$module_call = "Home";
			if($this_module)
				$module_call = $this->ssx_module;
			else
				$this->ssx_module = $module_call;
				
			if(!file_exists(LOCALPATH . "modules/".$module_call."/templates/404.tpl"))
				die('SSX MODULES: Action 404 precisa existir');
			
			$this->ssx_action_template = "404";

		}
	}
	
	/**
	 * Modifica a action recebida via codigo, desconsiderando a rota.
	 * Se essa função for chamada dentro do arquivo do Modulo, o acl será verificado.
	 * E qualquer verificação da action atual será perdida.
	 * @param string $action
	 */
	public function set_new_action($action)
	{
		$this->ssx_action = $action;
	}
	
	/**
	 * Marca que se caso não seja encontrado nenhuma action, redireciona para a action informada
	 * @param string $action
	 */
	public function set_slug_action($action)
	{
		$this->ssx_use_slug_action = true;
		$this->ssx_slug_action = $action;
	}
	
	public function get_slug_action()
	{
		if($this->ssx_use_slug_action)
			return $this->ssx_slug_action;
		return false;
	}
	
	public function disable_slug_action()
	{
		$this->ssx_use_slug_action = false;
		$this->ssx_slug_action = "";
	}
	
	/**
	 * Retorna se foi gerado o erro 404
	 */
	public function is_404()
	{
		if(!$this->action_found && !$this->ssx_use_slug_action)
		  return true;
		return false;
	}
	
	/**
	 * Retorna se foi gerado erro de acesso negado
	 * @return boolean
	 */
	public function isDenied()
	{
		if($this->action_denied)
			return true;
		return false;
	}
	
	public function setModuleLocale(SsxModulesLocale $locale)
	{
		$this->ssx_module_locale = $locale;
	}
	
	/**
	 * Habilita ou desabilita o header no tema
	 * @param boolean $visible
	 */
	public function showHeader($visible=true)
	{
		$this->_disable_header = ($visible)?false:true;
	}
	
	/**
	 * Habilita ou desabilita o footer no tema
	 * @param boolean $visible
	 */
	public function showFooter($visible=true)
	{
		$this->_disable_footer = ($visible)?false:true;
	}
	
	public function isCached($cache_id=null)
	{
		$tpl =  $this->getModuleTemplate();
		if($this->smarty->isCached($tpl,$cache_id))
			return true;
		return false;
	}
	
	public function clearCache($cache_id=null)
	{
		$tpl = $this->getModuleTemplate();
		$this->smarty->clearCache($tpl,$cache_id);
	}
	
	public function getModuleTemplate()
	{
		if($this->ssx_action_template && $this->ssx_module)
			return LOCALPATH . "modules/".$this->ssx_module."/templates/".$this->ssx_action_template.".tpl";
		return "";
	}
	
	public function display()
	{
		
		// caso seja ajax ou que seja solicitado a não renderização dos templates
		if((defined('IS_AJAX') && IS_AJAX) || (defined('NO_RENDER') && NO_RENDER))
			return;

		$this->ssx_modules_template =  $this->getModuleTemplate();
		
		// acrescenta a chance de um modulo ou açao se tornar um WebService
		if(defined('IS_WEBSERVICE') && IS_WEBSERVICE)
		{
			if(file_exists($this->ssx_theme_path ."/". "webservice.xml"))
			{
				define_xml();
				$this->ssx_display = $this->ssx_theme_path ."/". "webservice.xml";
			}else
				die(SSX_ERROR_MODULES_04);
		}
		
		// acrescenta a chance de um modulo ou açao se tornar um WebService
		if(defined('IS_FEED') && IS_FEED)
		{
			if(file_exists($this->ssx_theme_path ."/". "feed.xml"))
			{
				define_feed();
				$this->ssx_display = $this->ssx_theme_path ."/". "feed.xml";
			}else
				die(SSX_ERROR_MODULES_05);
		}
		
		$SsxAcl = new SsxAcl();
		
		$acl = $SsxAcl->convertToViewAccess(SsxUsers::getPermission(), SsxUsers::getRules());
		
		// ssx_head
		$this->smarty->assign('ssx_head', $this->head_content());		
		// gatilho ssx_display
		SsxActivity::dispatchActivity(SsxActivity::SSX_DISPLAY);
		
		$ssx_display = $this->ssx_display;		
		
		$this->smarty->assign('ssxacl', $acl);
		
		$this->smarty->assign('userid', SsxUsers::getUser(true));

		$this->smarty->assign('ssx_encoding', SSX_ENCODING);

		$this->smarty->assign('ssx_content_path', $this->ssx_modules_template);
		
		$siteurl =  siteurl();
		
		$this->smarty->assign('siteurl_clean',$siteurl);
		
		$siteurl .= ($this->use_locale?$this->ssx_locale."/":"");
		
		$this->smarty->assign('siteurl',$siteurl);
		
		$this->smarty->assign('projecturl', projecturl());
		
		$this->smarty->assign('coreurl', coreurl());
		
		$this->smarty->assign('serverurl', serverurl());
		
		$this->smarty->assign('theme_path', $this->ssx_theme_path);
		
		$this->smarty->assign('theme_url', $this->ssx_theme_url);
		
		$this->smarty->assign('image_url', siteurl() . "images/");
		
		$this->smarty->assign('this_module', strtolower($this->ssx_module));
		
		$this->smarty->assign('this_action', strtolower($this->ssx_action));
		
		$this->smarty->assign('this_action_template', strtolower($this->ssx_action_template));
		
		$this->smarty->assign('ssx_theme_title', $this->__ssx_theme_title);
		
		$this->smarty->assign('ssx_disable_header', $this->_disable_header);
		
		$this->smarty->assign('ssx_disable_footer', $this->_disable_footer);
		
		$this->smarty->assign('ssx_admin_id', Ssx::$project_data->ad_id);
		
		$this->smarty->assign('ssx_admin_group_id', Ssx::$project_data->ad_g_id);
		
		$this->smarty->assign('ssx_guest_id', Ssx::$project_data->g_id);
		
		$this->smarty->assign('locale', $this->ssx_module_locale);
		if(!defined('IS_ADMIN') || !IS_ADMIN)
		{
			$this->smarty->assign('l', Ssx::$locale->toScreen());
		}
		
		if($this->is_404())
			define_404();
			
		// show template
		if(defined("DISPLAY_ALONE") && DISPLAY_ALONE)
		{
			$this->smarty->display($this->ssx_modules_template);
		}else
			$this->smarty->display($ssx_display);
	}

	
	private $project_seo_description;
	
	private $project_seo_keyworkds;
	
	/**
	 * Configura padrão de SEO para o projeto,
	 * Todos esses padrões podem ser substituídos
	 */
	public function project_seo()
	{		 
		 if(the_platform() == "project")
		 {
			 // declare constantes e use funções de configurações aqui
			 $title 		= SsxConfig::get(SsxConfig::SSX_SEO_TITLE);
			 
			 $description 	= SsxConfig::get(SsxConfig::SSX_SEO_DESCRIPTION);
			 
			 $keywords 		= SsxConfig::get(SsxConfig::SSX_SEO_KEYWORDS);
			 
			 if($title)
			 	$this->set_theme_title($title, true);
			 
			 $this->project_seo_description = $description;
		 
			 $this->project_seo_keyworkds = $keywords;
		 }
				
	}
	
	public function project_seo_setDescription($description)
	{
		$this->project_seo_description = $description;
	}
	
	public function project_seo_setKeyworkds($keywords)
	{
		$this->project_seo_keyworkds = $keywords;
	}
	
	
	/*****************************
	 * Theme Utils
	 */
	
	public function add_head_content($content, $last=false)
	{
		if(!is_string($content))
		   return;	
		   
		if($last)
			$this->ssx_head[] = $content."\n";
		else
			array_unshift($this->ssx_head, $content."\n");
	}
	
	private $ssx_css_url = array();
	
	public function add_css_url($css_url, $first=false)
	{
		if($first)
			array_unshift($this->ssx_css_url, $css_url);
		else
			$this->ssx_css_url[] = $css_url;
	}
	
	public function add_head_meta($params, $last=false)
	{
		if(!is_array($params))
		   return;	
		   
		if($last)
			$this->ssx_head_meta[] = $params;
		else
			array_unshift($this->ssx_head_meta, $params);
	}
	
	private function head_content()
	{
		SsxActivity::dispatchActivity(SsxActivity::SSX_HEAD);
		
		$theme_css = $this->ssx_theme_url . "/" . $this->ssx_theme . ".css";
		
		load_js('core/underscore.js');
		load_js('core/jquery.1.7.2.min.js');
		load_js('core/Ssx.js');
		
		$jsParams = $this->jsParams();

		load_css($this->ssx_theme);
		
		//$SsxCssCompiler = new SsxCssCompiler();
		if($this->ssx_css_url)
		{
			foreach($this->ssx_css_url as $css)
			{
				//$SsxCssCompiler->addCss($css);
				$this->add_head_content('<link rel="stylesheet" href="'.$css.'" media="all" />',true);
			}
			//$css_compiled = $SsxCssCompiler->linkCss();		
		}
		
		$this->add_head_content('
								'.$jsParams.'
								');
		
  
		// dispara o gatilho de que o head do ssx estão sendo adicionadas a view agora
		/*
			$this->add_head_meta(array('http-equiv'=>'Pragma','content'=>'no-cache'));
			$this->add_head_meta(array('http-equiv'=>'Expires','content'=>gmdate('D, d M Y H:i:s \G\M\T', strtotime("+1"))));
			$this->add_head_meta(array('http-equiv'=>'Cache-control','content'=>'no-store'));
		*/
		
		$this->add_head_meta(array('http-equiv'=>'Content-Type','charset'=>constant('SSX_ENCODING'),'content'=>'text/html'));
		$this->add_head_meta(array('name'=>'generator','content'=>'Ssx '.constant('SSX_VERSION')));
		
		$this->add_head_meta(array('name'=>'description', 'content'=>$this->project_seo_description));
		$this->add_head_meta(array('property'=>'og:description', 'content'=>$this->project_seo_description));
		$this->add_head_meta(array('name'=>'keywords', 'content'=>$this->project_seo_keyworkds));
		
		$head_string = "";
		if($this->ssx_head_meta)
		{
			foreach($this->ssx_head_meta as $row)
			{
				$head_string .= "<meta ";
				foreach($row as $key => $list)
				{
					$head_string .= $key."='".$list."' ";
				}
				$head_string .= " />\n";
			}
		}		
		
		if($this->ssx_head)
		{
			foreach($this->ssx_head as $row)
			{
				$head_string .= (string)$row;
			}
		}
		return $head_string;
	}
	
	private function jsParams()
	{
		$content = "\n<script type=\"text/javascript\">var _ssx_siteurl = \"".siteurl()."\", _ssx_projecturl = \"".projecturl()."\";";
		if(defined('IS_ADMIN') && IS_ADMIN)
		{
			$content .= "var ad = true;";
		}else{
			$content .= "var ad = false;";
		}
	    $content .= "</script>\n";
	    return $content;
	}
	
	
	/**
	 * Define o titulo do projejo, sera enviado quando template for construido
	 * 
	 * @param string $title O titulo que sera colocado na pagina
	 * @param boolean $replace Se o titulo informado deve substituir o que ja existe
	 * @param boolean $before Se o titulo vai ficar antes ou depois do que ja tem
	 * @return void
	 */
	public function set_theme_title($title,$replace=false, $before=false)
	{
		if(!$title)
			return;
			
		if($replace)
		{
			$this->__ssx_theme_title = $title;
		}else{
			if($before)
			{
				$this->__ssx_theme_title = $title." ".$this->__ssx_theme_title;
			}else{
				$this->__ssx_theme_title = $this->__ssx_theme_title . " " . $title;
			}
		}
	}
	
	/**
	 * Util Smarty assign abreviation
	 * 
	 * @param $var_name nome da variavel
	 * @param $object valor da variavel a ser enviada ao tema
	 * @return void
	 */
	public function assign($var_name, $object)
	{
		if(!is_string($var_name))
			return;
		
		$this->smarty->assign($var_name, $object);
	}
}