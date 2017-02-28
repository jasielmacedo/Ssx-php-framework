<?php
/**
 * 
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 06/05/2016
 * 
 * 
 */

class SsxResponseHeadersVariables extends SsxRequestHeadersVariables
{
	/**
	 * @var array
	 */
	protected $computedCacheControl = array();

	/**
	 * @var array
	 */
	protected $headerNames = array();
	
	/**
	 * Array of future cookies
	 * @var array
	 */
	protected $cookies = array();
	
	/**
	 * Constructor.
	 *
	 * @param array $headers An array of HTTP headers
	 */
	public function __construct(array $headers = array())
	{
		parent::__construct($headers);
		
		if (!isset($this->headers['cache-control'])) 
		{
			$this->set('Cache-Control', '');
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		ksort($this->headerNames);
		return parent::__toString();
	}
	
	/**
	 * Returns the headers, with original capitalizations.
	 *
	 * @return array An array of headers
	 */
	public function allPreserveCase()
	{
		return array_combine($this->headerNames, $this->headers);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function replace(array $headers = array())
	{
		$this->headerNames = array();
		parent::replace($headers);
		
		if (!isset($this->headers['cache-control'])) 
		{
			$this->set('Cache-Control', '');
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function set($key, $values, $replace = true)
	{
		parent::set($key, $values, $replace);
		
		$uniqueKey = str_replace('_', '-', strtolower($key));
		
		$this->headerNames[$uniqueKey] = $key;
		
		// ensure the cache-control header has sensible defaults
		if (in_array($uniqueKey, array('cache-control', 'etag', 'last-modified', 'expires'))) 
		{
			$computed = $this->computeCacheControlValue();
			
			$this->headers['cache-control'] = array($computed);
			$this->headerNames['cache-control'] = 'Cache-Control';
			$this->computedCacheControl = $this->parseCacheControl($computed);
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function remove($key)
	{
		parent::remove($key);
		$uniqueKey = str_replace('_', '-', strtolower($key));
		
		unset($this->headerNames[$uniqueKey]);
		
		if ('cache-control' === $uniqueKey) 
		{
			$this->computedCacheControl = array();
		}
	}
	
	
	public function setCookie(SsxCookie $cookie)
	{
		$this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;
	}
	
	public function getCookies($flat = true)
	{
		if(false === $flat)
		{
			return $this->cookies;
		}
		
		$flattenedCookies = array();
		
		foreach ($this->cookies as $domains) 
		{
			foreach ($domains as $paths) 
			{
				foreach ($paths as $cookie) 
				{
					$flattenedCookies[] = $cookie;
				}
			}
		}
		return $flattenedCookies;
	}
	
	public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
	{
		$this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly));
	}
	
	public function removeCookie($name, $path = '/', $domain = null)
	{
		if (null === $path) 
		{
			$path = '/';
		}
		
		unset($this->cookies[$domain][$path][$name]);
		
		if (empty($this->cookies[$domain][$path])) 
		{
			unset($this->cookies[$domain][$path]);
			
			if (empty($this->cookies[$domain])) 
			{
				unset($this->cookies[$domain]);
			}
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function hasCacheControlDirective($key)
	{
		return array_key_exists($key, $this->computedCacheControl);
	}
	/**
	 * {@inheritdoc}
	 */
	public function getCacheControlDirective($key)
	{
		return array_key_exists($key, $this->computedCacheControl) ? $this->computedCacheControl[$key] : null;
	}
	
	protected function computeCacheControlValue()
	{
		if (!$this->cacheControl && !$this->has('ETag') && !$this->has('Last-Modified') && !$this->has('Expires')) 
		{
			return 'no-cache';
		}
		
		if (!$this->cacheControl) 
		{
			// conservative by default
			return 'private, must-revalidate';
		}
		
		$header = $this->getCacheControlHeader();
		
		if (isset($this->cacheControl['public']) || isset($this->cacheControl['private'])) 
		{
			return $header;
		}
		
		// public if s-maxage is defined, private otherwise
		if (!isset($this->cacheControl['s-maxage'])) 
		{
			return $header.', private';
		}
		
		return $header;
	}
}