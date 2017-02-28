<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 * 
 */

class SsxString
{
	public static function getRandomString($length=10,$useSymbols=true)
	{
		$result = '';
        $chars = 'abcdefghi1j2k3l4m5n6o7p8q9rstuvwxyzABC2D3E4F5G6HIJKLMNOPQRSTUVWXYZ1234567890';
        if($useSymbols)
        	$chars .= '!@#$[]}{';
        
        $charsTotal  = strlen($chars);
        
        for ($i = 0; $i < $length; $i++) 
        {
            $rInt = (integer) mt_rand(0, $charsTotal);
            $result .= substr($chars, $rInt, 1);
        }
        return $result;
	}
	
	
	public static function guid()
	{
		//Cria uma nova chave para ser gravada no banco de dados
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);
	
		$dec_hex = sprintf("%x", $a_dec* 1000000);
		$sec_hex = sprintf("%x", $a_sec);
	
		self::ensure_length($dec_hex, 5);
		self::ensure_length($sec_hex, 6);
	
		$guid = "";
		$guid .= $dec_hex;
		$guid .= self::create_guid_section(3);
	
		$guid .= '-';
		$guid .= self::create_guid_section(4);
	
		$guid .= '-';
		$guid .= self::create_guid_section(4);
	
		$guid .= '-';
		$guid .= self::create_guid_section(4);
	
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= self::create_guid_section(6);
	
		return $guid;
	}
	
	private static function create_guid_section($characters){
		$return = "";
		for($i=0; $i<$characters; $i++)
			$return .= sprintf("%x", mt_rand(0,15));
			return $return;
	}
	
	private static function ensure_length(&$string, $length){
		$strlen = strlen($string);
		if($strlen < $length)
			$string = str_pad($string,$length,"0");
			else if($strlen > $length)
				$string = substr($string, 0, $length);
	}
	
	public static function toString($obj)
	{
		return (string)$obj;
	}
	
}