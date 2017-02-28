<?php
/**
 * Centralize the crypt system
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class Crypt
{
	public static function isSupported()
	{
		if(function_exists('mcrypt_decrypt') && function_exists('mcrypt_encrypt'))
			return true;
		return false;
	}
	
	
	/**
	 * Usa uma chave para criar um hash usando CBC
	 * 
	 * @param string $hash
	 * @param string $keypair
	 * @return string
	 */
	public static function decrypt($hash, $keypair)
	{
		if(!self::isSupported())
		{
			die("Crypt não é suportado pelo sistema");
		}
		
		if(!$keypair)
		{
			die('Crypt: Não há como descriptografar sem inserir a chave.');
		}
	
		$key = pack('a*',$keypair);
	
		$iv_size = mcrypt_get_iv_size(MCRYPT_SAFERPLUS, MCRYPT_MODE_CBC);
	
		$ciphertext_dec = base64_decode($hash);
	
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
	
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
	
		$decrypted = mcrypt_decrypt(MCRYPT_SAFERPLUS, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	
		return $decrypted;
	}
	
	
	public static function encrypt($hash,$keypair)
	{
		if(!self::isSupported())
		{
			die("Crypt não é suportado pelo sistema");
		}
		
		if(!$keypair)
		{
			die('Crypt: Não há como criptografar sem inserir a chave.');
		}
	
		$key = pack('a*',$keypair);
	
		$iv_size = mcrypt_get_iv_size(MCRYPT_SAFERPLUS, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	
		$ciphertext = mcrypt_encrypt(MCRYPT_SAFERPLUS, $key, $hash, MCRYPT_MODE_CBC, $iv);
		$ciphertext = $iv . $ciphertext;
		$ciphertext_base64 = base64_encode($ciphertext);
	
		return $ciphertext_base64;
	}
	
}