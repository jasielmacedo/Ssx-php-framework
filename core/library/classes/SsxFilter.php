<?php
/**
 * 
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */
class SsxFilter
{
	public function isDigit(&$str)
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
	
	public function isAlnum(&$str)
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
	
	public function isSafestr(&$str)
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
	
	public function isName(&$str)
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
	
	public function isPassSimple(&$str)
	{
		if(is_string($str))
		{
			if(preg_match("/^([a-zA-Z0-9!@#\$.]{4,16})$/", $str))
			{
				return true;
			}
		}
		return false;
	}
	
	public function isFloat(&$str)
	{
		if(is_numeric($str) || is_string($str) || is_real($str))
		{
			if(preg_match("/^[-+]?[0-9]+[.]?[0-9]*([eE][-+]?[0-9]+)?$/i", $str))
				return true;
		}
		return false;
	}
	
	public function isUser(&$str)
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
	
	public function isEmail(&$str)
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
	
	public function isText(&$str)
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
		$lower = mb_strtolower($lower,Ssx::$request->encoding);
	}
}