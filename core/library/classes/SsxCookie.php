<?php
/**
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0 
 * 
 */

class SsxCookie
{
	/**
	 * Name of the cookie
	 * @var string
	 */
	protected $name;
	
	/**
	 * Value of the cookie
	 * @var string
	 */
	protected $value;
	
	/**
	 * Cookie Domain
	 * @var string
	 */
	protected $domain;
	
	/**
	 * Time to expires
	 * @var int|string|\DateTime|\DateTimeInterface
	 */
	protected $expire;
	
	protected $path;
	
	/**
	 * Is the cookie is secure format
	 * @var bool
	 */
	protected $secure;
	
	/**
	 * Is the cookie httpOnly
	 * @var bool
	 */
	protected $httpOnly;
	
	/**
	 * Is rawCookie
	 * @var bool
	 */
	private $raw;
	
	/**
	 * 
	 * @param string $name
	 * @param string $value
	 * @param number $expire
	 * @param string $path
	 * @param string $domain
	 * @param bool $secure
	 * @param bool $httpOnly
	 * @param bool $raw
	 * @throws \InvalidArgumentException
	 */
	public function __construct($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httpOnly = true, $raw = false)
	{
		// from PHP source code
		if (preg_match("/[=,; \t\r\n\013\014]/", $name)) 
		{
			throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
		}
		
		if (empty($name)) 
		{
			throw new \InvalidArgumentException('The cookie name cannot be empty.');
		}
		
		// convert expiration time to a Unix timestamp
		if ($expire instanceof \DateTime || $expire instanceof \DateTimeInterface) 
		{
			$expire = $expire->format('U');
		} elseif (!is_numeric($expire)) 
		{
			$expire = strtotime($expire);
			if (false === $expire || -1 === $expire) 
			{
				throw new \InvalidArgumentException('The cookie expiration time is not valid.');
			}
		}
		
		$this->name = $name;
		$this->value = $value;
		$this->domain = $domain;
		$this->expire = $expire;
		$this->path = empty($path) ? '/' : $path;
		$this->secure = (bool) $secure;
		$this->httpOnly = (bool) $httpOnly;
		$this->raw = (bool) $raw;
	}
	
	/**
	* Returns the cookie as a string.
	*
	* @return string The cookie
	*/
	public function __toString()
	{
		$str = urlencode($this->getName()).'=';
		
		if ('' === (string) $this->getValue()) 
		{
			$str .= 'deleted; expires='.gmdate('D, d-M-Y H:i:s T', time() - 31536001);
		} else {
			$str .= urlencode($this->getValue());
			if ($this->getExpiresTime() !== 0) {
				$str .= '; expires='.gmdate('D, d-M-Y H:i:s T', $this->getExpiresTime());
			}
		}
		if ($this->path) 
		{
			$str .= '; path='.$this->path;
		}
		
		if ($this->getDomain()) 
		{
			$str .= '; domain='.$this->getDomain();
		}
		if (true === $this->isSecure()) 
		{
			$str .= '; secure';
		}
		if (true === $this->isHttpOnly()) 
		{
			$str .= '; httponly';
		}
		
		return $str;
	}
	
	
	/**
	 * Gets the name of the cookie.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	/**
	 * Gets the value of the cookie.
	 *
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}
	/**
	 * Gets the domain that the cookie is available to.
	 *
	 * @return string
	 */
	public function getDomain()
	{
		if(null === $this->domain)
		{
			$this->domain = Ssx::$request->getHttpHost();
		}
		return $this->domain;
	}
	/**
	 * Gets the time the cookie expires.
	 *
	 * @return int
	 */
	public function getExpiresTime()
	{
		return $this->expire;
	}
	/**
	 * Gets the path on the server in which the cookie will be available on.
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
	/**
	 * Checks whether the cookie should only be transmitted over a secure HTTPS connection from the client.
	 *
	 * @return bool
	 */
	public function isSecure()
	{
		return $this->secure;
	}
	/**
	 * Checks whether the cookie will be made accessible only through the HTTP protocol.
	 *
	 * @return bool
	 */
	public function isHttpOnly()
	{
		return $this->httpOnly;
	}
	/**
	 * Whether this cookie is about to be cleared.
	 *
	 * @return bool
	 */
	public function isCleared()
	{
		return $this->expire < time();
	}
	/**
	 * Checks if the cookie value should be sent with no url encoding.
	 *
	 * @return bool
	 */
	public function isRaw()
	{
		return $this->raw;
	}
}