<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class SsxRequestMaster
{
	/**
	 * $_GET variable
	 * @var SsxRequestVariables
	 */
	public $query;
	
	/**
	 * $_POST variable
	 * @var SsxRequestVariables
	 */
	public $request;
	
	/**
	 * $_COOKIE variable
	 * @var SsxRequestVariables
	 */
	public $cookie;
	
	/**
	 * $_SERVER variable
	 * @var SsxRequestServerVariables
	 */
	public $server;
	
	/**
	 * $_FILES variable
	 * @var SsxRequestFilesVariables
	 */
	public $files;
		
	/**
	 * Headers received
	 * @var SsxRequestHeadersVariables
	 */
	public $headers;
	
	/**
	 * received from php://input
	 * @var unknown
	 */
	public $content;
	
	/**
	 * List of request formats
	 * @var array
	 */
	public $formats;
	
	
	protected $baseUrl;
	
	protected $requestUri;
	
	protected $pathInfo;
	
	protected $method;
	
	public function __construct()
	{
		$this->collectVariables();
	}
	
	protected function initialize(array $query = array(), array $request = array(), array $cookies = array(), array $files = array(), array $server = array())
	{
		$this->query = new SsxRequestVariables($query);
		$this->request = new SsxRequestVariables($request);
		$this->cookie = new SsxRequestVariables($cookies);
		$this->files = new SsxRequestFilesVariables($files);
		$this->server = new SsxRequestServerVariables($server);
		$this->headers = new SsxRequestHeadersVariables($this->server->getHeaders());
		$this->content = null;
		
		$this->setFormats();
		
		$this->baseUrl = null;
		$this->requestUri = null;
		$this->pathInfo = null;
		$this->method = null;
	}	
	
	protected function collectVariables()
	{
		$server = $_SERVER;
		if ('cli-server' === PHP_SAPI) 
		{
			if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) 
			{
				$server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
			}
			if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) 
			{
				$server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
			}
		}
		
		$this->initialize($_GET, $_POST, $_COOKIE, $this->mapPhpFiles(), $server);

		$content = null;		
		
		if (0 === strpos($this->headers->get('CONTENT_TYPE'), 'application/x-www-form-urlencoded') && in_array(strtoupper($this->server->get('REQUEST_METHOD', 'GET')), array('PUT', 'DELETE', 'PATCH'))) 
		{
			parse_str($this->getContent(), $content);
			$this->content = $content;
		}
	}
	
	/**
	 * Zend Framework (http://framework.zend.com/)
	 *
	 * @link      http://github.com/zendframework/zf2 for the canonical source repository
	 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
	 * @license   http://framework.zend.com/license/new-bsd New BSD License
	 *
	 * Convert PHP superglobal $_FILES into more sane parameter=value structure
	 * This handles form file input with brackets (name=files[])
	 *
	 * @return array
	 */
	protected function mapPhpFiles()
	{
		$files = array();
		foreach ($_FILES as $fileName => $fileParams) 
		{
			$files[$fileName] = array();
			foreach ($fileParams as $param => $data) {
				if (!is_array($data)) {
					$files[$fileName][$param] = $data;
				} else {
					foreach ($data as $i => $v) {
						$this->mapPhpFileParam($files[$fileName], $param, $i, $v);
					}
				}
			}
		}
	
		return $files;
	}
	
	/**
	 *
	 * Zend Framework (http://framework.zend.com/)
	 *
	 * @link      http://github.com/zendframework/zf2 for the canonical source repository
	 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
	 * @license   http://framework.zend.com/license/new-bsd New BSD License
	 *
	 * @param array        $array
	 * @param string       $paramName
	 * @param int|string   $index
	 * @param string|array $value
	 */
	protected function mapPhpFileParam(&$array, $paramName, $index, $value)
	{
		if (!is_array($value)) {
			$array[$index][$paramName] = $value;
		} else {
			foreach ($value as $i => $v) {
				$this->mapPhpFileParam($array[$index], $paramName, $i, $v);
			}
		}
	}
	
	public function isSecure()
	{
		$https = $this->server->get('HTTPS');
		
		return !empty($https) && 'off' !== strtolower($https);
	}
	
	public function getScheme()
	{
		return $this->isSecure() ? 'https' : 'http';
	}
	
	public function getPort()
	{
		if ($host = $this->headers->get('HOST')) 
		{
			if ($host[0] === '[') 
			{
				$pos = strpos($host, ':', strrpos($host, ']'));
			} else 
			{
				$pos = strrpos($host, ':');
			}
			
			if (false !== $pos) 
			{
				return (int) substr($host, $pos + 1);
			}
			
			return 'https' === $this->getScheme() ? 443 : 80;
		}
		
		return $this->server->get('SERVER_PORT');
	}
	
	public function getHost()
	{
		if (!$host = $this->headers->get('HOST')) 
		{
			if (!$host = $this->server->get('SERVER_NAME')) 
			{
				$host = $this->server->get('SERVER_ADDR', '');
			}
		}

		$host = strtolower(preg_replace('/:\d+$/', '', trim($host)));

		if ($host && '' !== preg_replace('/(?:^\[)?[a-zA-Z0-9-:\]_]+\.?/', '', $host)) 
		{
			throw new \UnexpectedValueException(sprintf('Invalid Host "%s"', $host));
		}
		
		return $host;
	}
	
	public function getHttpHost()
	{
		$scheme = $this->getScheme();
		$port = $this->getPort();
		
		if (('http' == $scheme && $port == 80) || ('https' == $scheme && $port == 443)) 
		{
			return $this->getHost();
		}
		return $this->getHost().':'.$port;
	}
	
	public function getSchemeAndHttpHost()
	{
		return $this->getScheme().'://'.$this->getHttpHost();
	}
	
	public function getClientIp()
	{
		$ip = getenv('HTTP_CLIENT_IP');
		if(!$ip)
		{
			if ($this->server->has('HTTP_CLIENT_IP') && null === ($clientIp = $this->server->get('HTTP_CLIENT_IP')))
			{
				$ip = $clientIp;
			} elseif ($this->server->has('HTTP_X_FORWARDED_FOR') && null === ($clientIp = $this->server->get('HTTP_X_FORWARDED_FOR')))
			{
				$ip = $clientIp;
			} else {
				$ip = $this->server->get('REMOTE_ADDR');
			}
		}
		return $ip;
	}
	
	public function getClientUserAgent()
	{
		return $this->server->get('HTTP_USER_AGENT');
	}
	
	/**
	 * Initializes HTTP request formats.
	 */
	protected function setFormats()
	{
		$this->formats = array(
				'html' => array('text/html', 'application/xhtml+xml'),
				'txt' => array('text/plain'),
				'js' => array('application/javascript', 'application/x-javascript', 'text/javascript'),
				'css' => array('text/css'),
				'json' => array('application/json', 'application/x-json'),
				'xml' => array('text/xml', 'application/xml', 'application/x-xml'),
				'rdf' => array('application/rdf+xml'),
				'atom' => array('application/atom+xml'),
				'rss' => array('application/rss+xml'),
				'form' => array('application/x-www-form-urlencoded'),
		);
	}
	
	
	public function getBaseUrl()
	{
		if(null === $this->baseUrl)
		{
			$this->baseUrl = $this->prepareBaseUrl();
		}
		
		return $this->baseUrl;
	}
	
	/**
	 * Prepares the base URL.
	 *
	 * @return string
	 */
	protected function prepareBaseUrl()
	{
		$filename = basename($this->server->get('SCRIPT_FILENAME'));
		
		if (basename($this->server->get('SCRIPT_NAME')) === $filename) 
		{
			$baseUrl = $this->server->get('SCRIPT_NAME');
		} elseif (basename($this->server->get('PHP_SELF')) === $filename) 
		{
			$baseUrl = $this->server->get('PHP_SELF');
		} elseif (basename($this->server->get('ORIG_SCRIPT_NAME')) === $filename) 
		{
			$baseUrl = $this->server->get('ORIG_SCRIPT_NAME'); // 1and1 shared hosting compatibility
		} else 
		{
			// Backtrack up the script_filename to find the portion matching
			// php_self
			$path = $this->server->get('PHP_SELF', '');
			$file = $this->server->get('SCRIPT_FILENAME', '');
			
			$segs = explode('/', trim($file, '/'));
			$segs = array_reverse($segs);
			$index = 0;
			$last = count($segs);
			$baseUrl = '';
			do {
				$seg = $segs[$index];
				$baseUrl = '/'.$seg.$baseUrl;
				++$index;
			} while ($last > $index && (false !== $pos = strpos($path, $baseUrl)) && 0 != $pos);
		}
		
		// Does the baseUrl have anything in common with the request_uri?
		$requestUri = $this->getRequestUri();
		
		if ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, $baseUrl)) {
			// full $baseUrl matches
			return $prefix;
		}
		if ($baseUrl && false !== $prefix = $this->getUrlencodedPrefix($requestUri, rtrim(dirname($baseUrl), '/'.DIRECTORY_SEPARATOR).'/')) {
			// directory portion of $baseUrl matches
			return rtrim($prefix, '/'.DIRECTORY_SEPARATOR);
		}
		
		$truncatedRequestUri = $requestUri;
		
		if (false !== $pos = strpos($requestUri, '?')) {
			$truncatedRequestUri = substr($requestUri, 0, $pos);
		}
		$basename = basename($baseUrl);
		if (empty($basename) || !strpos(rawurldecode($truncatedRequestUri), $basename)) 
		{
			// no match whatsoever; set it blank
			return '';
		}
		// If using mod_rewrite or ISAPI_Rewrite strip the script filename
		// out of baseUrl. $pos !== 0 makes sure it is not matching a value
		// from PATH_INFO or QUERY_STRING
		if (strlen($requestUri) >= strlen($baseUrl) && (false !== $pos = strpos($requestUri, $baseUrl)) && $pos !== 0) 
		{
			$baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
		}
		return rtrim($baseUrl, '/'.DIRECTORY_SEPARATOR);
	}
	
	public function getRequestFolder()
	{
		return $this->getSchemeAndHttpHost().$this->getBaseUrl();
	}
	
	public function getRequestUri()
	{
		if(null === $this->requestUri)
			$this->requestUri = $this->prepareRequestUri();
		
		return $this->requestUri;
	}
	
	protected function prepareRequestUri()
	{
		$requestUri = '';
		
		if ($this->headers->has('X_ORIGINAL_URL')) 
		{
			// IIS with Microsoft Rewrite Module
			$requestUri = $this->headers->get('X_ORIGINAL_URL');
			$this->headers->remove('X_ORIGINAL_URL');
			$this->server->remove('HTTP_X_ORIGINAL_URL');
			$this->server->remove('UNENCODED_URL');
			$this->server->remove('IIS_WasUrlRewritten');
		} elseif ($this->headers->has('X_REWRITE_URL')) 
		{
			// IIS with ISAPI_Rewrite
			$requestUri = $this->headers->get('X_REWRITE_URL');
			$this->headers->remove('X_REWRITE_URL');
		} elseif ($this->server->get('IIS_WasUrlRewritten') == '1' && $this->server->get('UNENCODED_URL') != '') 
		{
			// IIS7 with URL Rewrite: make sure we get the unencoded URL (double slash problem)
			$requestUri = $this->server->get('UNENCODED_URL');
			$this->server->remove('UNENCODED_URL');
			$this->server->remove('IIS_WasUrlRewritten');
		} elseif ($this->server->has('REQUEST_URI')) 
		{
			$requestUri = $this->server->get('REQUEST_URI');
			// HTTP proxy reqs setup request URI with scheme and host [and port] + the URL path, only use URL path
			$schemeAndHttpHost = $this->getSchemeAndHttpHost();
			if (strpos($requestUri, $schemeAndHttpHost) === 0) 
			{
				$requestUri = substr($requestUri, strlen($schemeAndHttpHost));
			}
		} elseif ($this->server->has('ORIG_PATH_INFO')) 
		{
			// IIS 5.0, PHP as CGI
			$requestUri = $this->server->get('ORIG_PATH_INFO');
			if ('' != $this->server->get('QUERY_STRING')) {
				$requestUri .= '?'.$this->server->get('QUERY_STRING');
			}
			$this->server->remove('ORIG_PATH_INFO');
		}
		
		// normalize the request URI to ease creating sub-requests from this request
		$this->server->set('REQUEST_URI', $requestUri);
		return $requestUri;
	}
	
	public function getPathInfo()
	{
		if(null === $this->pathInfo)
			$this->pathInfo = $this->preparePathInfo();
		
		return $this->pathInfo;
	}
	
	protected function preparePathInfo()
	{
		$baseUrl = $this->getBaseUrl();
		
		if (null === ($requestUri = $this->getRequestUri())) 
		{
			return '/';
		}
		// Remove the query string from REQUEST_URI
		if ($pos = strpos($requestUri, '?')) 
		{
			$requestUri = substr($requestUri, 0, $pos);
		}
		$pathInfo = substr($requestUri, strlen($baseUrl));
		
		if (null !== $baseUrl && (false === $pathInfo || '' === $pathInfo)) {
			// If substr() returns false then PATH_INFO is set to an empty string
			return '/';
		} elseif (null === $baseUrl) {
			return $requestUri;
		}
		return (string) $pathInfo;
	}
	
	/**
	 * Generates a normalized URI (URL) for the Request.
	 * @return string A normalized URI (URL) for the Request
	 *
	 * @see getQueryString()
	 */
	public function getUri()
	{
		if (null !== $qs = $this->getQueryString()) 
		{
			$qs = '?'.$qs;
		}
		return $this->getSchemeAndHttpHost().$this->getBaseUrl().$this->getPathInfo().$qs;
	}
	
	/**
	 * Get Url without query requests
	 * @return string
	 */
	public function getUrl()
	{
		return $this->getSchemeAndHttpHost().$this->getBaseUrl().$this->getPathInfo();
	}
	
	/**
	 * Generates a normalized URI for the given path
	 * @param string $path
	 * @return string
	 */
	public function getUriForPath($path)
	{
		return $this->getSchemeAndHttpHost().$this->getBaseUrl().$path;
	}
	
	/**
	 * Returns the path as relative reference from the current Request path.
	 * 
	 * @param string $path
	 */
	public function getRelativeUriForPath($path)
	{
		// be sure that we are dealing with an absolute path
		if (!isset($path[0]) || '/' !== $path[0]) 
		{
			return $path;
		}
		
		if ($path === $basePath = $this->getPathInfo()) 
		{
			return '';
		}
		
		$sourceDirs = explode('/', isset($basePath[0]) && '/' === $basePath[0] ? substr($basePath, 1) : $basePath);
		$targetDirs = explode('/', isset($path[0]) && '/' === $path[0] ? substr($path, 1) : $path);
		
		array_pop($sourceDirs);
		
		$targetFile = array_pop($targetDirs);
		
		foreach ($sourceDirs as $i => $dir) 
		{
			if (isset($targetDirs[$i]) && $dir === $targetDirs[$i]) 
			{
				unset($sourceDirs[$i], $targetDirs[$i]);
			} else 
			{
				break;
			}
		}
		
		$targetDirs[] = $targetFile;
		$path = str_repeat('../', count($sourceDirs)).implode('/', $targetDirs);
		
		
		return !isset($path[0]) || '/' === $path[0] || false !== ($colonPos = strpos($path, ':')) && ($colonPos < ($slashPos = strpos($path, '/')) || false === $slashPos)? "./$path" : $path;
	}
	
	protected $previousUrl = false;
	
	public function getPreviousUrl()
	{
		if(false !== $this->previousUrl)
			return $this->previousUrl;
		
		$previous = $this->headers->get('referer',null);
		if(null !== $previous)
		{			
			$ex = explode("?", $previous);
			$this->previousUrl = reset($ex);
			return $this->previousUrl;
		}
		return null;
	}
	
	public function getContent($asResource = false)
	{
		$currentContentIsResource = is_resource($this->content);
		
		if (PHP_VERSION_ID < 50600 && false === $this->content) 
		{
			throw new \LogicException('getContent() can only be called once when using the resource return type and PHP below 5.6.');
		}
		
		if (true === $asResource) 
		{
			if ($currentContentIsResource) 
			{
				rewind($this->content);
				return $this->content;
			}
			
			// Content passed in parameter (test)
			if (is_string($this->content)) 
			{
				$resource = fopen('php://temp', 'r+');
				fwrite($resource, $this->content);
				rewind($resource);
				return $resource;
			}
			
			$this->content = false;
			return fopen('php://input', 'rb');
		}
		
		if ($currentContentIsResource) 
		{
			rewind($this->content);
			return stream_get_contents($this->content);
		}
		
		if (null === $this->content) 
		{
			$this->content = file_get_contents('php://input');
		}
		
		return $this->content;
	}
	
	public function getQueryString()
	{
		$qs = $this->normalizeQueryString($this->server->get('QUERY_STRING'));
		return '' === $qs ? null : $qs;
	}
	
	/**
	 * Normalizes a query string.
	 *
	 * @param string $qs Query string
	 * @return string A normalized query string for the Request
	 */
	public function normalizeQueryString($qs)
	{
		if ('' == $qs) 
		{
			return '';
		}
		
		$parts = array();
		$order = array();
		foreach (explode('&', $qs) as $param) 
		{
			if ('' === $param || '=' === $param[0]) {
				// Ignore useless delimiters, e.g. "x=y&".
				// Also ignore pairs with empty key, even if there was a value, e.g. "=value", as such nameless values cannot be retrieved anyway.
				// PHP also does not include them when building _GET.
				continue;
			}
			$keyValuePair = explode('=', $param, 2);
			// GET parameters, that are submitted from a HTML form, encode spaces as "+" by default (as defined in enctype application/x-www-form-urlencoded).
			// PHP also converts "+" to spaces when filling the global _GET or when using the function parse_str. This is why we use urldecode and then normalize to
			// RFC 3986 with rawurlencode.
			$parts[] = isset($keyValuePair[1]) ?
			rawurlencode(urldecode($keyValuePair[0])).'='.rawurlencode(urldecode($keyValuePair[1])) :
			rawurlencode(urldecode($keyValuePair[0]));
			$order[] = urldecode($keyValuePair[0]);
		}
		array_multisort($order, SORT_ASC, $parts);
		return implode('&', $parts);
	}
	
	public function getFormat($mimeType)
	{
		$canonicalMimeType = null;
		if (false !== $pos = strpos($mimeType, ';')) 
		{
			$canonicalMimeType = substr($mimeType, 0, $pos);
		}
		if (null === $this->$formats) {
			$this->setFormats();
		}
		foreach ($this->$formats as $format => $mimeTypes) 
		{
			if (in_array($mimeType, (array) $mimeTypes)) 
			{
				return $format;
			}
			if (null !== $canonicalMimeType && in_array($canonicalMimeType, (array) $mimeTypes))
			{
				return $format;
			}
		}
	}
	
	public function getMimeType($format)
	{
		if (null === $this->formats) {
			$this->setFormats();
		}
		return isset($this->formats[$format]) ? $this->formats[$format][0] : null;
	}
	
	public function getContentType()
	{
		return $this->getFormat($this->headers->get('CONTENT_TYPE'));
	}
	
	public function getMethod()
	{
		if (null === $this->method) 
		{
			$this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
			
			if ('POST' === $this->method) 
			{
				if ($method = $this->headers->get('X-HTTP-METHOD-OVERRIDE')) 
				{
					$this->method = strtoupper($method);
				} 
			}
		}
		return $this->method;
	}
	
	public function getRealMethod()
	{
		return strtoupper($this->server->get('REQUEST_METHOD', 'GET'));
	}	
	
	public function isMethod($method)
	{
		return $this->getMethod() === strtoupper($method);
	}
	
	public function isXmlHttpRequest()
	{
		return 'xmlhttprequest' == strtolower($this->headers->get('X-Requested-With'));
	}
	
	public function checkXmlHttpRequestOrigin()
	{
		if($this->isXmlHttpRequest())
		{
			if($this->headers->get('Origin') == serverurl())
			{
				return true;
			}
		}		
		return false;
	}
	
	protected function getUrlencodedPrefix($string, $prefix)
	{
		if (0 !== strpos(rawurldecode($string), $prefix)) 
		{
			return false;
		}
		
		$len = strlen($prefix);
		if (preg_match(sprintf('#^(%%[[:xdigit:]]{2}|.){%d}#', $len), $string, $match)) 
		{
			return $match[0];
		}
		return false;
	}
}