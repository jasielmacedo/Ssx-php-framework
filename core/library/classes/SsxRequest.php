<?php
/**
 * 
 * Versão melhorada da SsxRequest
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @since 18/09/2014
 * 
 */
class SsxRequest extends SsxRequestMaster
{
	
	const TYPE_ENV = 1;
	const TYPE_FRIENDLY = 2;
	const TYPE_COOKIE = 3;
	const TYPE_POST = 4;
	const TYPE_QUERY = 5;
	const TYPE_FILES = 6;
	
	const FILTER_TYPE_SAFESTRING = 1;
	const FILTER_TYPE_NUMBER = 2;
	const FILTER_TYPE_TEXT = 3;
	const FILTER_TYPE_NAME = 4;
	const FILTER_TYPE_EMAIL = 5;
	const FILTER_TYPE_FLOAT = 6;
	const FILTER_TYPE_USER = 7;
	const FILTER_TYPE_PASSWORD_SIMPLE = 8;
	const FILTER_TYPE_PASSWORD_COMPLEX = 9;

	protected $friendly;
	
	public $encoding;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->encoding = (defined('SSX_ENCODING') && SSX_ENCODING)?SSX_ENCODING:"UTF-8";
		
		$this->getFriendly();
	}
	
	private function setParams(&$params, &$to)
	{
		if(!$params || !is_array($params) || count($params) < 1)
			return;
		
		foreach ($params as $key => $value)
		{
			if(is_string($value))
			{
				$to[$key] = self::setEncoding($value, $this->encoding);
			}elseif(is_array($value))
			{
				foreach($value as $keyChild => $valueChild)
				{
					if(is_string($valueChild))
						$to[$key][$keyChild] = self::setEncoding($valueChild, $this->encoding);
					else
						$to[$key][$keyChild] = $valueChild;
				}
			}
		}
	}
	
	public function isPost(){ return "post" === strtolower($this->getMethod()); }
	public function isQuery(){ return "get" === strtolower($this->getMethod()); }
	public function isPut(){ return "put" === strtolower($this->getMethod()); }
	public function isHead(){ return "head" === strtolower($this->getMethod()); }
	
	public function fromQuery($key, $child=null){ return $this->from(self::TYPE_QUERY,$key,$child); }
	public function fromPost($key, $child=null){ return $this->from(self::TYPE_POST,$key,$child); }
	public function fromEnv($key, $child=null){ return $this->from(self::TYPE_ENV,$key); }
	public function fromCookie($key, $child=null){ return $this->from(self::TYPE_COOKIE,$key,$child); }
	public function fromFriendlyUrl($key){ return $this->from(self::TYPE_FRIENDLY,$key); }
	public function fromFiles($key){ return $this->from(self::TYPE_FILES,$key); }
	
	protected function from($type, $key, $child=null)
	{		
		$return = false;		
		switch($type)
		{
			case self::TYPE_FRIENDLY:
				$params = $this->friendly;
				if($params && is_array($params) && isset($params[$key]) && $params[$key])
					$return = trim($params[$key]);
				else
					$return = false;
			break;
			case self::TYPE_FILES:
				$return = $this->files->get($key,false);
			break;
			case self::TYPE_ENV:
				$return = getenv($key);
			break;
			case self::TYPE_COOKIE:
				$return = $this->cookie->get($key,false);
			break;
			case self::TYPE_POST:
				$return = $this->request->get($key,false);
			break;
			case self::TYPE_QUERY:
				$return = $this->query->get($key,false);
			break;
		}	
		
		if(false !== $return && null !== $child && is_array($return) && array_key_exists($return, $child))
		{
			return $return[$child];
		}		
		return $return;
	}
	
	
	public function filter($collected,$type,$limit=null)
	{
		if($collected !== false)
		{				
				
			switch ($type)
			{
				case SsxRequest::FILTER_TYPE_NUMBER:
					if(!$this->is_digit($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_NAME:
					if(!$this->is_name($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_EMAIL:
					if(!$this->is_email($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_PASSWORD_SIMPLE:
					if(!$this->is_pass_simple($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_TEXT:
					if(!$this->is_text($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_USER:
					if(!$this->is_user($collected))
						return false;
						break;
				case SsxRequest::FILTER_TYPE_SAFESTRING:
				default:
					if(!$this->is_alnum($collected))
						return false;
						break;
			}
			
			if($collected)
			{
				if($limit && is_int($limit))
				{
					$collected = substr($collected,0,$limit);
				}
				return $collected;
			}
				
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
			//$str = $this->escape($str);
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
			//$str = $this->escape($str);
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
	
	private function getFriendly()
	{
		$onlyothers = parent::getPathInfo();
		
	
		if(substr($onlyothers,0,1) == "/")
		{
			$onlyothers = substr($onlyothers,1,strlen($onlyothers)-1);
		}

		$params = explode("/", $onlyothers);

		$this->friendly = $params;
	}
	
	public function trim(&$value)
	{
		if(is_string($value))
			$value = trim($value);
	}
	
	
	/**
	 * List of encoding support
	 * @var array
	 */
	private static $encodingList;
	 
	public static function setEncoding($str, $newEncoding="UTF-8")
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