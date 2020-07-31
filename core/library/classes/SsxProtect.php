<?php
/**
 * 
 * Classe de proteção para vários tipos de ataques por dados sensíveis
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0 
 * 
 */

class SsxProtect
{
	
	/**
	 * 
	 * Tempo limite para verificação. default é 5 minutos
	 * @var int
	 */
	public $timeout = 300;
	
	
	/**
	 * 
	 * Nome da sessão de verificação. Trocar sempre que possível.
	 * @var string
	 */
	public $verification = "__ssx_protect_cftok";
	
	
	/**
	 * 
	 * Habilita criar um hash aleatorio para ser o nome do campo, para evitar tentativas
	 * @var bool
	 */
	private $random_field = false;
	
	/**
	 * Para multiplos locais evitando a confusão ao acessar duas urls
	 * @var string
	 */
	private $local_prefix = "default";
	
	/**
	 * Para checar a url da onde se destina
	 * @var string
	 */
	private $checkReferer = false;
	
	/**
	 * 
	 * Construct
	 * @param int $timeout
	 * @param bool $hashField
	 */
	public function __construct($timeout=300, $hashField=false, $local="default", $checkReferer = true)
	{
		$this->timeout = (int)$timeout;
		$this->random_field = $hashField;
		$this->local_prefix = $local;
		$this->checkReferer = $checkReferer;

		if(!SsxSession::getSessionID())
			die("SSX PROTECT ERROR: Não foi possível gerar o token corretamente.");
	}	
	

	public static function getRandomString($length=10)
	{
		return SsxString::getRandomString($length);
	}
	
	private function getHash()
	{
		$sData = SsxSession::get($this->verification);
		return sha1(implode('|', $sData[$this->local_prefix]));
	}
	
	private function generateToken()
	{
		$sData[$this->local_prefix] = array(
			'mtime'=>time(),
			'field'=>($this->random_field?generate_pass(rand(30,45)):"tkcs"),
			'hash'=>self::getRandomString(45),
			'sess_id'=>SsxSession::getSessionID(),
			'ip'=>Ssx::$request->getClientIp(),
			'requestUrl'=>sha1(Ssx::$request->getUrl()),
		);
		
		SsxSession::set($this->verification, $sData);
		
		$hash = $this->getHash();
		
		return base64_encode($hash);
	}
	
	private function checkTimeout()
	{
		$sData = SsxSession::get($this->verification);
		return (Ssx::$request->server->get('REQUEST_TIME') - $sData[$this->local_prefix]['mtime']) < $this->timeout;
	}
	
	private function comparePreviousUrl()
	{
		if(!$this->checkReferer)
			return true;
		
		$previous = Ssx::$request->getPreviousUrl();
		if(null !== $previous)
		{
			$sData = SsxSession::get($this->verification);
			$previous = sha1($previous);
			if($sData[$this->local_prefix]['requestUrl'] == $previous)
			{
				return true;
			}
		}
		return false;
	}
	
	public function getField()
	{
		$hash = $this->generateToken();
		$sData = SsxSession::get($this->verification);
		return "<input type=\"hidden\" name=\"".$sData[$this->local_prefix]['field']."\" value=\"$hash\" />";
	}
	
	public function getFieldValue()
	{
		return $this->generateToken();
	}
	
	/**
	 * 
	 * Checa se o token recebido é realmente o que foi enviado
	 * dentro do tempo limite da transição
	 * 
	 * @return true|false
	 */
	public function checkToken()
	{
		$sData = SsxSession::get($this->verification);
		
		if(null === $sData)
			return false;
		
		if(isset($sData[$this->local_prefix]) && is_array($sData[$this->local_prefix]) &&  SsxSession::getSessionID())
		{
			if($this->checkTimeout() && $this->comparePreviousUrl())
			{
				$name_field = $sData[$this->local_prefix]['field'];
				
				
				$requestPost = Ssx::$request->fromPost($name_field);
				
				if($requestPost)
				{
					$requestPost = base64_decode($requestPost);
					$hash = $this->getHash();
					
					if($requestPost && $hash)
					{
						return $requestPost == $hash;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 *
	 * Checa se o token recebido é realmente o que foi enviado baseado no valor informado
	 * dentro do tempo limite da transição8
	 *
	 * @return true|false
	 */
	public function checkTokenByValue($value)
	{
		if(null === ($sData = SsxSession::get($this->verification)))
			return false;
		
		if(isset($sData[$this->local_prefix]) && is_array($sData[$this->local_prefix]) &&  SsxSession::getSessionID())
		{
			if($this->checkTimeout())
			{
				$requestPost = $value;
		
				if($requestPost)
				{
					$requestPost = base64_decode($requestPost);
					$hash = $this->getHash();
						
					if($requestPost && $hash)
					{
						return $requestPost == $hash;
					}
				}
			}
		}
		return false;
	}
	
	public static function decrypt($hash, $keypair)
	{
		return Crypt::decrypt($hash, $keypair);
	}
	
	
	public static function encrypt($hash,$keypair)
	{
		return Crypt::encrypt($hash, $keypair);
	}
}