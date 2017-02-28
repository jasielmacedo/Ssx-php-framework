<?php
/**
 * 
 * 
 * Classe de controle de requisições
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 * 
 */

class SsxRequest2
{
	const TYPE_SAFESTRING = 1;
	const TYPE_NUMBER = 2;
	const TYPE_TEXT = 3;
	const TYPE_NAME = 4;
	const TYPE_EMAIL = 5;
	const TYPE_FLOAT = 6;
	const TYPE_USER = 7;
	const TYPE_PASSWORD_SIMPLE = 8;
	const TYPE_PASSWORD_COMPLEX = 9;
	const TYPE_NOFILTER = 10;
	
	private $posts;
	private $posts_cleaned;
	
	private $gets;
	private $gets_cleaned;
	private $encoding;
	
	public function __construct()
	{
		$this->gets = $_GET;
		$this->posts = $_POST;
		
		$this->encoding = (defined('SSX_ENCODING') && SSX_ENCODING)?SSX_ENCODING:"UTF-8";
	}	
	
	
	public function thePost($name,$type=SsxRequest::TYPE_NOFILTER,$limit=null)
	{
		return $this->collect(true,$name, $type, $limit,true);
	}
	
	public function theGet($name,$type=SsxRequest::TYPE_NOFILTER,$limit=null)
	{
		return $this->collect(false,$name, $type, $limit);
	}
	
	protected function collect($post=false,$name,$type,$limit,$check_from=false)
	{		
		
		$collected = false;
		
		if($post)
		{
			if(isset($this->posts_cleaned[$name]))
			{
				return $this->posts_cleaned[$name];
			}else if(isset($this->posts[$name]))
			{
				$collected = $this->posts[$name];
			}
		}else{
			if(isset($this->gets_cleaned[$name]))
			{
				return $this->gets_cleaned[$name];
			}elseif(isset($this->gets[$name]))
			{
				$collected = $this->gets[$name];
			}
		}
		
		if($collected !== false && !is_array($collected))
		{
			$collected = self::setEncoding($collected,$this->encoding);
			$collected = str_ireplace("script", "blocked", $collected);
			
			switch ($type)
			{
				case SsxRequest::TYPE_NUMBER:
					if(!$this->is_digit($collected))
						return false;
				break;
				case SsxRequest::TYPE_NAME:
					if(!$this->is_name($collected))
						return false;
				break;
				case SsxRequest::TYPE_EMAIL:
					if(!$this->is_email($collected))
						return false;
				break;
				case SsxRequest::TYPE_PASSWORD_SIMPLE:
					if(!$this->is_pass_simple($collected))
						return false;
				break;
				case SsxRequest::TYPE_TEXT:
					if(!$this->is_text($collected))
						return false;
				break;
				case SsxRequest::TYPE_USER:
					if(!$this->is_user($collected))
						return false;
					break;
				case SsxRequest::TYPE_SAFESTRING:
					if(!$this->is_alnum($collected))
						return false;
				break;
			}
			
			if($post)
				$this->posts_cleaned[$name] = $collected;
			else
				$this->gets_cleaned[$name] = $collected;
			
			if($collected)
			{
				if($limit && is_int($limit))
				{
					$collected = substr($collected,0,$limit);
				}
				return $collected;
			}
		}else if(is_array($collected))
		{
			if($post)
				$this->posts_cleaned[$name] = $collected;
			else
				$this->gets_cleaned[$name] = $collected;
							
			return $collected;
		}
		
		return false;
	}
	
	public function is_digit(&$str)
	{
		if(is_int($str)) 
		{
            return true;
        }else if(is_string($str))
        {
            return ctype_digit($str);
        }			
		return false;
	}
	
	public function is_alnum(&$str)
	{
		if(is_string($str))
		{
			if(ctype_alnum($str))
			{
				return true;
			}
		}
		return false;
	}
	
	public function is_safestr(&$str)
	{
		if(is_string($str))
		{
			if(preg_match("/^[a-zA-Z0-9 .-]+$/i", $str))
			{
				$str = addslashes($str);
				return true;
			}
		}
		return false;
	}
	
	public function is_name(&$str)
	{
		if(is_string($str))
		{
			$str = $this->escape($str);
			if(preg_match("/^([a-zA-Z0-9]+[, ]*(.)*)+$/i", $str))
			{
				return true;
			}
		}
		return false;
	}
	
	public function is_pass_simple(&$str)
	{
		if(is_string($str))
		{
			if(preg_match("/^([a-zA-Z0-9!@#\$.]{4,16})$/", $str))
			{
				return true;
			}
		}
	}
	
	public function is_float(&$str)
	{
		if(is_numeric($str) || is_string($str) || is_real($str))
		{
			if(preg_match("/^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$/i", $str))
				return true;
		}
		return false;
	}
	
	public function is_user(&$str)
	{
		if(is_string($str))
		{
			$str = $this->escape($str);
			if(preg_match("/^([a-zA-Z0-9]+[.-_]*)+$/i", $str))
			{
				return true;
			}else if($this->is_email($str))
				return true;
		}
		return false;
	}
	
	public function is_email(&$str)
	{
		if(is_string($str))
		{
			if(preg_match("/^[a-zA-Z0-9+&*-]+(?:\.[a-zA-Z0-9_+&*-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,7}$/i", $str))
				return true;
		}
		return false;
	}
	
	protected function escape($value) 
	{
	    $return = '';
	    for($i = 0; $i < strlen($value); ++$i) {
	        $char = $value[$i];
	        $ord = ord($char);
	        if($char !== "'" && $char !== "\"" && $char !== '\\'/* && $ord >= 32 && $ord <= 126 */)
	            $return .= $char;
	        else
	            $return .= '\\x' . dechex($ord);
	    }
	    return $return;
	}
	
	public function is_text(&$str)
	{
		if(is_string($str))
		{
			$sanitizer = new HtmlSanitizer();
			
			$sanitizer->allowStyle();
			$sanitizer->allowHtml5Media();
			$sanitizer->allowIframes();
			
			$str = $sanitizer->removeEvilTags( $str );
			$str = $sanitizer->removeEvilAttributes( $str );
			
			//$str = $this->escape($str);
			return true;
		}
		return false;
	}
	
	public function lower(&$lower)
	{
		$lower = mb_strtolower($lower,$this->encoding);
	}
	
	public function checkOrigin()
	{
		if(function_exists('apache_request_headers'))
		{
			$header = apache_request_headers();
			
			if(isset($header['Origin']) && $header['Origin'] && $header['Origin'] == serverurl())
			{
				return true;
			}else if(isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == serverurl())
			{
				return true;
			}
		}else{
			if(isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == serverurl())
				return true;
		}
		return false;
	}
	
	/**
	 * List of encoding support
	 * @var array
	 */
	private static $encodingList;
   
   /**
	* @function   : setEncoding
	* @return     : String
	* @parameters : str: Content you want to change the character encoding
	*               newEncoding: Character encoding you want set
	* @description: Convert the character encoding of the string
	*               to newEncoding from currentEncoding. currentEncoding
	*               detecting by function so you only need give str and
	*               newEncoding to the setEncoding function.
	*/
	public static function setEncoding($str, $newEncoding) 
	{
		$encodingList = self::$encodingList;
		if(!$encodingList)
		{
			self::$encodingList = mb_list_encodings();
			$encodingList = self::$encodingList;
		}
		
		$currentEncoding = mb_detect_encoding($str, $encodingList);
		$changeEncoding = mb_convert_encoding($str, $newEncoding, $currentEncoding);
	
		return $changeEncoding;
	}
}