<?php
/**
 * Classe de controle e criação de sessão
 * Usa cookie e session para manter tudo organizado
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 */

defined("SSX") or die;

/**
 * 
 * @package Ssx
 * @subpackage SsxAuthSession
 * @version 1.0
 * 
 */
class SsxAuthSession
{
	/**
	 * Nome que sera dado a sessao
	 * @var string static
	 */
	public static $__session_name = "s1623_8_8321_0u13_ssx";
	
	/**
	 * Nome que sera dado a um cookie
	 * @var string static
	 */
	public static $__cookie_name = "ssx_sd175";
	
	/**
	 * Abre uma sessão no sistema
	 * 
	 * @param array $session_val Dados que serão armazenados na sessao, necessario ser array
	 * @param boolean $replace 
	 * @param string $session_name Nome da sessão, se não for informada, ira usar um nome padrão
	 * @param boolean $use_cookie_verification Usa um cookie com hash para prender a sessão em dois lugares
	 * @return void
	 */
	public static function openSession(array $session_val, $replace=false, $session_name="", $use_cookie_verification=true)
	{
		
		$platform = sha1(the_platform());
		
		if(!$session_name)
		{
			$session_name = SsxAuthSession::$__session_name;
			$cookie_name = SsxAuthSession::$__cookie_name;
		}else{
			$cookie_name = md5($session_name);
		}
		
		$cookie_name .= $platform;	

		
		
		if((!SsxAuthSession::getSession($session_name)) || (SsxAuthSession::getSession($session_name) && $replace))
		{
			SsxAuthSession::dropSession($session_name);
			
			$sData[$session_name] = array(
				'value'=> $session_val,
				'sess_id'=>SsxSession::getSessionID(),
				'agent'=>client_user_agent(),
				'value'=>$session_val,
				'check_cookie'=>$use_cookie_verification
			);
			
			$hash_session =  sha1($sData[$session_name]['agent']."|".$sData[$session_name]['sess_id']);
			
			SsxSession::set($platform, $sData);
				
			if($use_cookie_verification)
			{
				self::refreshVerificationCookie($cookie_name, $hash_session);
			}
			
		}
	
	}
	
	public static function refreshVerificationCookie($cookieName,$cookieValue)
	{
		$base = Ssx::$request->getBaseUrl();
		if('' === $base)
			$base = "/";
		
		Ssx::$response->headers->setCookie(
			new SsxCookie(
					$cookieName,
					$cookieValue,
					\Carbon\Carbon::now()->addHours(2)
					,$base,
					null,
					false,false)
		);
		
		Ssx::$request->cookie->set($cookieName,$cookieValue);
	}
	
	public static function removeVerificationCookie($cookieName)
	{
		Ssx::$response->headers->setCookie(
			new SsxCookie($cookieName, null,\Carbon\Carbon::now())		
		);
	}
	
	/**
	 * Verifica se existe uma sessão valida no sistema
	 * @return boolean
	 */
	public static function getSession($session_name="")
	{
		$platform = sha1(the_platform());
		
		if(!$session_name)
		{
			$session_name = SsxAuthSession::$__session_name;
			$cookie_name  = SsxAuthSession::$__cookie_name;
		}else
		{
			$cookie_name = md5($session_name);
		}
		
		$cookie_name .= $platform;
		
		$sessionData = SsxSession::get($platform);
		
		if(null === $sessionData)
			return false;

		if(isset($sessionData[$session_name]) && $sessionData[$session_name])
		{
			if(isset($sessionData[$session_name]['agent']) && $sessionData[$session_name]['agent'] == client_user_agent())
			{
				if(isset($sessionData[$session_name]['check_cookie']) && $sessionData[$session_name]['check_cookie'])
				{
					$cookieData = Ssx::$request->cookie->get($cookie_name);
					
					if(null !== $cookieData)
					{
						$hash = sha1($sessionData[$session_name]['agent']."|".$sessionData[$session_name]['sess_id']);
						
						if($hash == $cookieData)
						{
							self::refreshVerificationCookie($cookie_name, $cookieData);							
							return $sessionData[$session_name]['value'];
						}
					}
				}else{
					return $sessionData[$session_name]['value'];
				}
			}
		}
		return false;
	}
	
	/**
	 * Derruba a sessao existe
	 * @return void
	 */
	public static function dropSession($session_name="")
	{
		$platform = sha1(the_platform());
		
		if(!$session_name)
		{
			$session_name = SsxAuthSession::$__session_name;
			
			$cookie_name = SsxAuthSession::$__cookie_name;
			
		}else
		{
			$cookie_name = md5($session_name);
		}
		
		$cookie_name .= $platform;
		
		$sData = SsxSession::get($platform);
		
		if(isset($sData[$session_name]) && $sData[$session_name])
		{
			unset($sData[$session_name]);
			SsxSession::set($platform, $sData);
		}
		
		self::removeVerificationCookie($cookie_name);
	}
}