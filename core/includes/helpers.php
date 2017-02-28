<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

 defined("SSX") or die;
 
if(!function_exists('domain_name'))
{
	/**
	 * Retorna o nome do dominio em questao
	 * @return string
	 */
	 function domain_name($withport=true)
	 { 	
	 	return Ssx::$request->getHttpHost();
	 }
}
 
if(!function_exists('serverurl'))
{
	/**
	 * Retorna apenas o dominio na qual o projeto está hospedado, contando também com a PORTA
	 * @return string
	 */  
	function serverurl($force_https=false)
	{
		return Ssx::$request->getSchemeAndHttpHost();
	}
}

if(!function_exists('server_protocol'))
{
	function server_protocol($force_https= false)
	{
		$protocol = Ssx::$request->getScheme() . "://";
		if($force_https)
		{
			$protocol = "https://";
		}
		return $protocol;
	}
}

if(!function_exists('is_https'))
{
	function is_https()
	{
		return Ssx::$request->isSecure();
	}
}

if(!function_exists('client_ip'))
{
	function client_ip()
	{
		return Ssx::$request->getClientIp();
	}
}

if(!function_exists('client_user_agent'))
{
	function client_user_agent()
	{
		return Ssx::$request->getClientUserAgent();
	}
}

if(!function_exists('siteurl'))
{
	/**
	 * Retorna o endereço do site completo, se ele estiver dentro de alguma subpasta ou não
	 * @return string
	 */
	function siteurl($force_https=false)
	{
		return Ssx::$request->getRequestFolder() . "/";
	}
}

if(!function_exists('projecturl'))
{
	/**
	 *  Retorna a url absoluta do projeto desconsiderando o admin
	 *  Levando em consideração que a flag IS_ADMIN só foi dada a uma subpasta do projeto.
	 *  @return string
	 */
	function projecturl()
	{
		$baseUrl = Ssx::$request->getBaseUrl();
		
		if(defined('IS_ADMIN') && IS_ADMIN)
		{
			if($baseUrl[0] == "/")
				$baseUrl = substr($baseUrl,1);
			
			$baseUrlList = explode("/",$baseUrl);
			unset($baseUrlList[count($baseUrlList)-1]);
			$baseUrl = "/" . implode("/", $baseUrlList);
		}
		
		if("" === $baseUrl || $baseUrl[strlen($baseUrl)-1] != "/")
			$baseUrl .= "/";
		
		return Ssx::$request->getSchemeAndHttpHost() . $baseUrl;
	}
}

if(!function_exists('themeurl'))
{
	/**
	 * Retorna a url absoluta até o tema
	 * @return string|string
	 */
	function themeurl()
	{
		
		$siteurl = siteurl();
		
		if(!defined("SSX_THEME"))
			return $siteurl;
			
		$siteurl .= "themes/" .  Ssx::$themes->ssx_theme . "/";
		
		return $siteurl;
	}
}

if(!function_exists('coreurl'))
{
	/**
	 *  Retorna a url absoluta da core
	 *  @deprecated Nao havera mais formas de acessar a url da core, uma vez que a core não será na raiz visível do site.
	 */
	function coreurl()
	{
		/** descontinuada */
		return projecturl();
	}
}

if(!function_exists('get_request'))
{
	/**
	 * Retorna uma requisição _GET ou _POST ou _REQUEST caso ela exista
	 * 
	 * @param $request_name nome do sta
	 * @param $check_injection se true, passa o elemento por uma verificação de sql injection
	 * @return mixed
	 */
	function get_request($request_name,$from="GET",$limit=0)
	{		
		if(strtolower($from)=="post")
			return Ssx::$request->fromPost($request_name);
		else if(strtolower($from)=="request")
		{
			$result = Ssx::$request->fromPost($request_name);
			if(!$result)
				$result = Ssx::$request->fromQuery($key);
				
			return $result;
		}
		return Ssx::$request->fromQuery($request_name);
	}
}

if(!function_exists('check_request_origin'))
{
	/**
	 * Verifica se essa requisicao foi enviada por ajax
	 */
	function check_request_origin()
	{
		if(Ssx::$request->isXmlHttpRequest())
		{				
			if(Ssx::$request->checkXmlHttpRequestOrigin())
			{
				if(!defined('IS_AJAX'))
					define('IS_AJAX', true);
				return true;
			}else
			{
				define_403();die;
			}
		}
		return false;
	}
}

if(!function_exists('define_xml'))
{
	/**
	 * Marca no cabeçalho content-type XML
	 * @return void
	 */
	function define_xml()
	{
	  	Ssx::$response->setContentType('xml');
	}
}

if(!function_exists('define_feed'))
{
	function define_feed()
	{
		Ssx::$response->setContentType('rss');
	}
}
if(!function_exists('define_json'))
{
	function define_json()
	{
		Ssx::$response->setContentType('json');
	}
}

if(!function_exists('define_404'))
{
	/**
	 * Marca no cabeçalho o status 404
	 * @return void
	 */
	function define_404()
	{
		Ssx::$response->setStatusCode(404);
	}
}

if(!function_exists('define_403'))
{
	/**
	 * Marca no cabeçalho o status 403
	 * @return void
	 */
	function define_403()
	{
		Ssx::$response->setStatusCode(403);
	
	}
}

if(!function_exists('get_url'))
{
	/**
	 * Monta a url de um modulo e ação
	 * 
	 * @param $module string
	 * @param $action string
	 * @param $params Array|string
	 * @param $admin boolean
	 * @param $anchor string
	 * @return string Url absoluta ate o modulo
	 */
	function get_url($module="Home", $action="index", $params="", $admin=false, $anchor="")
	{
		$siteurl = siteurl();
		
		if($admin)
		{
			$siteurl .= constant('ADMIN_FOLDER')."/";
		}
		
		$m = strtolower($module);
		$a = strtolower($action);
		
		$p = "";
		if($params)
		{
			if(is_array($params))
				$params = http_build_query($params);
			$p = "?" . $params;
		}
		
		if($anchor)
		{
			$anchor = "#".$anchor;
		}
		
		if($m == "home" && $action == "index")
			return $siteurl  . $p . $anchor;
			
		if($m == "home")
		{
			return $siteurl . $action . $p . $anchor;
		}else{
			if($a == "index")
				return $siteurl . $m  . $p . $anchor;
			else
				return $siteurl . $m . "/" . $a  . $p . $anchor; 
		}
		
	
		return $siteurl . $p . $anchor;
	}
}

if(!function_exists('header_redirect'))
{
	/**
	 * Redireciona via header
	 * @return void
	 */
	function header_redirect($url)
	{
		if(!$url)
			return;
			
		Ssx::$response->headerRedirect($url);
	}
}

if(!function_exists('redirect'))
{
	function redirect($url, $inIframe=false)
	{
		if($inIframe)
			print "<script type='text/javascript'> top.location.href = '".$url."';</script>";
		else
			print "<script type='text/javascript'> window.location.href = '".$url."';</script>";
		exit;
	}
}

/******************* Utils do modulo **********************/

if(!function_exists('the_module'))
{
	/**
	 * Retorna o modulo que esta sendo carregado
	 * 
	 * @return string 
	 */
	function the_module()
	{	
		$return = Ssx::$themes->ssx_module;
		
		if($return)
			return strtolower($return);
		return false;
	}
}

if(!function_exists('the_action'))
{
	/**
	 * Retorna a acao que sera exibida
	 * 
	 * @return string
	 */
	function the_action()
	{
		
		$return = Ssx::$themes->ssx_action;
		
		if($return)
			return strtolower($return);
		return false;
	}
}

if(!function_exists('the_platform'))
{
	/**
	 * 
	 * Retorna a plataforma a qual o usuário está acessando
	 * return @string
	 */
	function the_platform()
	{
		if(defined('IS_ADMIN') && IS_ADMIN)
			return "admin";
		return "project";
	}
}

if(!function_exists('theme_view_assign'))
{
	/**
	 * Envia para a view variaveis
	 * 
	 * @param $var_name nome da variavel a ser enviada para o tema
	 * @param $value valor da variavel a ser enviada para o tema
	 * @return void
	 */
	function theme_view_assign($var_name, $value)
	{
	
		Ssx::$themes->assign($var_name, $value);
		
		return;
	}
}

if(!function_exists('emptyComplete'))
{
	/**
	* Retorna string vazia se a variavel indicada não tiver um valor valido
	* @param $var string
	* @param $opcional_value caso seja indicada, o valor a ser retornado caso não encontre, será o dessa variável
	* @return mixed
	*/
	function emptyComplete($var,$opcional_value="")
	{	
		return Ssx::$utils->emptyComplete($var,$opcional_value);
	}
}

if(!function_exists('debug'))
{
	/**
	 * Mostra no HTML junto com a tag <pre> o conteúdo que ha dentro do elemento informado
	 * 
	 * @param mixed $obj
	 * @param boolean $die
	 * return void
	 */
	function debug($obj, $die=false)
	{	
		Ssx::$utils->debug($obj,$die);
		
		return;
	}
}

if(!function_exists('load_js'))
{
	function load_js($js_name, $autocomplete=true)
	{
		
		if(!is_string($js_name))
			return;
		if($autocomplete)
			$js_name .= substr($js_name,strlen($js_name)-3,3) != ".js"?".js":"";
		
		
		if(!preg_match('/((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))/is',$js_name ))
		{
			if(file_exists(LOCALLOWPATH . "themes/" . Ssx::$themes->ssx_theme . "/js/" . $js_name))
			{
				Ssx::$themes->add_head_content("<script type='text/javascript' src='".themeurl()."js/".$js_name."'></script>");	
			}else if(file_exists(PROJECTLOWPATH . "themes/" . Ssx::$themes->ssx_theme . "/js/" . $js_name))
			{
				
				Ssx::$themes->add_head_content("<script type='text/javascript' src='".projecturl()."themes/".Ssx::$themes->ssx_theme."/js/".$js_name."'></script>");
			}
		}else{
			Ssx::$themes->add_head_content("<script type='text/javascript' src='".$js_name."'></script>");	
		}
		return;
	}
}

if(!function_exists('load_css'))
{
	/**
	 * 
	 * @param string $css_name
	 */
	function load_css($css_name, $first=false)
	{
		
		if(!is_string($css_name))
			return false;
		
		$css_name .= substr($css_name,strlen($css_name)-4,4) != ".css"?".css":"";
		
		if(file_exists(LOCALLOWPATH . "themes/" . Ssx::$themes->ssx_theme . "/" . $css_name))
		{
			
			Ssx::$themes->add_css_url(Ssx::$themes->ssx_theme_url.'/'.$css_name,$first);
			return true;
		}
		return false;
	}
}

if(!function_exists('find_file'))
{
	function find_file($folder, $file_name)
	{
		if(!is_dir($folder))
			return false;
			
		$handle = scandir($folder);
		if(!$handle)
			return false;
			
		unset($handle[0]);
		unset($handle[1]);
		
		if(count($handle)<1)
			return false;
			
		foreach($handle as $row)
		{
			if(is_dir($folder . $row))
				return find_file($folder . "/" .$row, $file_name);
			else
			{
				if($row == $file_name)
					return $folder . "/" .$row;
			}
		}
		return false;
	}
}

if(!function_exists('calc_date_distance'))
{
	function calc_date_distance($date_db)
	{
		if(!is_string($date_db))
			return "";
		
		$dateParams = explode(" ", $date_db);
		$date = explode("-", $dateParams[0]);	
		$hour = explode(":", $dateParams[1]);
		
	 	$mkdata_question = mktime($hour[0], $hour[1], $hour[2], $date[1], $date[2], $date[0]);
	    $mkdata_atual = mktime();
	 
	    
	    $hour_mileseconds = (60 * 60);
	    $day_mileseconds = (60 * 60) * 24;
	    $week_mileseconds = $day_mileseconds * 7;
	    
	    $mileCalc =  $mkdata_atual - $mkdata_question;
	    $mileCalc = Math::Abs($mileCalc);
	    
	    $message = "";
	    if($mileCalc <= $hour_mileseconds)
	    {
	    	if($mileCalc < 60)
	    	{
	    		$message = "Há alguns segundos atrás";
	    	}else{
	    		$minutes = ceil($mileCalc / 60);
	    		$message = "Há ".$minutes." minuto".(($minutes>1)?"s":"")." atrás"; 
	    	}
	    }else if($mileCalc > $hour_mileseconds && $mileCalc <= $day_mileseconds)
	    {
	    	$hours = ceil($mileCalc / 60 / 60);
	    	$message = "Há ".$hours." hora".(($hours>1)?"s":"")." atrás";
	    }else if($mileCalc > $day_mileseconds && $mileCalc <= $week_mileseconds)
	    {
	    	$days = ceil((($mileCalc / 60) / 60) / 24);
	    	$message = "Há ".$days." dia".(($days>1)?"s":"")." atrás";
	    }else{
	    	$message = (strlen($date[2])<2)?"0".$date[2]:$date[2] . "/" . $date[1] . "/" . $date[0] ." ".$hour[0].":".$hour[1];
	    }
	    
	    return $message;
	}
}

if(!function_exists('is_location'))
{
	function is_location($module="home", $action="index")
	{
		if(siteurl() . the_module() . "/" . the_action() == siteurl() . $module . "/" . $action)
			return true;
		return false;	
	}
}

if(!function_exists('is_real_location'))
{
	function is_real_location($module="home")
	{
		// in construction
	}
}

if(!function_exists('generate_pass'))
{
	/**
	 * Gera uma senha aleatória de acordo com o tamanho informado
	 * @param int $length
	 * @return string
	 */
	function generate_pass($length=6)
	{
		if($length<0)
			return false;
		
		$alphabeto = "abcdefghi1j2k3l4m5n6o7p8q9rstuvwxyzABC2D3E4F5G6HIJKLMNOPQRSTUVWXYZ1234567890";
		$new_pass = "";
		
		for($i = 0; $i < $length; $i++)
		{
			$rand = rand(0,strlen($alphabeto)-1);
			$pos = substr($alphabeto,$rand,1);
			$new_pass .= $pos;
		}
		return $new_pass;
	}
}

if(!function_exists('makedir'))
{
	/**
	 *
	 */
	function makedir($absolute_path)
	{
		if(PHP_OS == "Linux")
	    {
	    	mkdir($absolute_path, 0777, true);
	    	chmod($absolute_path, 0777);
	    }
	}
}


/**
 * SsxModels
 */
if(!function_exists('mainprefix'))
{
	function mainprefix()
	{
		return defined('SSX_DB_PREFIX_TABLE') && SSX_DB_PREFIX_TABLE?constant('SSX_DB_PREFIX_TABLE')."_":"";
	}
}

if(!function_exists('ssx_get_table_logs'))
{
	function ssx_get_table_logs($result)
	{
		if(!$result)
			return $result;
		
		$SsxUsers = new SsxUsers();
		
		if(isset($result[0]) && is_array($result[0]))
		{
			foreach($result as $key => $row)
			{
				if(isset($row['created_by']))
				{
					$creator = $SsxUsers->fill($row['created_by']);
					$result[$key]['created_by'] = $creator['name'];
				}
				
				if(isset($row['modified_by']))
				{
					$creator = $SsxUsers->fill($row['modified_by']);
					$result[$key]['modified_by'] = $creator['name'];
				}
				
				if(isset($row['date_created']))
				{
					$result[$key]['date_created'] = Ssx::$utils->formatDate($row['date_created'],'d/m/Y H:i:s');
				}
				
				if(isset($row['date_modified']))
				{
					$result[$key]['date_modified'] = Ssx::$utils->formatDate($row['date_modified'],'d/m/Y H:i:s');
				}
			}
		}else{
				if(isset($result['created_by']))
				{
					$creator = $SsxUsers->fill($result['created_by']);
					$result['created_by'] = $creator['name'];
				}
				
				if(isset($result['modified_by']))
				{
					$creator = $SsxUsers->fill($result['modified_by']);
					$result['modified_by'] = $creator['name'];
				}
			
				if(isset($result['date_created']))
				{
					$result['date_created'] = Ssx::$utils->formatDate($result['date_created'],'d/m/Y H:i:s');
				}
				
				if(isset($result['date_modified']))
				{
					$result['date_modified'] = Ssx::$utils->formatDate($result['date_modified'],'d/m/Y H:i:s');
				}
		}
		
		return $result;
	}
}