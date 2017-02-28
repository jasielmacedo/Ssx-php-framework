<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 06/05/2016
 * 
 */

class SsxResponse
{
	/**
	 * Headers Bag
	 * @var SsxResponseHeadersVariables
	 */
	public $headers;
	

	/**
	 * Status codes translation table.
	 *
	 * The list of codes is complete according to the
	 * {@link http://www.iana.org/assignments/http-status-codes/ Hypertext Transfer Protocol (HTTP) Status Code Registry}
	 * (last updated 2015-05-19).
	 *
	 * Unless otherwise noted, the status code is defined in RFC2616.
	 *
	 * @var array
	 */
	public static $statusTexts = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			102 => 'Processing',            // RFC2518
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',          // RFC4918
			208 => 'Already Reported',      // RFC5842
			226 => 'IM Used',               // RFC3229
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			307 => 'Temporary Redirect',
			308 => 'Permanent Redirect',    // RFC7238
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Payload Too Large',
			414 => 'URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Range Not Satisfiable',
			417 => 'Expectation Failed',
			418 => 'I\'m a teapot',                                               // RFC2324
			422 => 'Unprocessable Entity',                                        // RFC4918
			423 => 'Locked',                                                      // RFC4918
			424 => 'Failed Dependency',                                           // RFC4918
			425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
			426 => 'Upgrade Required',                                            // RFC2817
			428 => 'Precondition Required',                                       // RFC6585
			429 => 'Too Many Requests',                                           // RFC6585
			431 => 'Request Header Fields Too Large',                             // RFC6585
			451 => 'Unavailable For Legal Reasons',                               // RFC7725
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
			507 => 'Insufficient Storage',                                        // RFC4918
			508 => 'Loop Detected',                                               // RFC5842
			510 => 'Not Extended',                                                // RFC2774
			511 => 'Network Authentication Required',                             // RFC6585
	);
	
	
	/**
	 *
	 * @var int
	 */
	protected $statusCode;
	
	/**
	 * 
	 * @var string
	 */
	protected $statusText;
	
	/**
	 *
	 * @var String
	 */
	protected $contentType;
	
	/**
	 * HTTP Protocol version
	 * @var int
	 */
	protected $version;
	
	/**
	 * Document Charset
	 * @var string
	 */
	protected $charset;
	
	
	
	/**
	 * Construct Class
	 * 
	 * @param SsxResponseHeadersVariables $headers
	 * @param int $status
	 */
	public function __construct(SsxRequestHeadersVariables $headers, $status)
	{
		$this->headers = new SsxResponseHeadersVariables($headers->getAll());
		$this->setStatusCode($status);
		$this->setProtocolVersion("1.0");
		$this->setContentType('html');
		$this->pushContent();
	}
	
	protected function pushContent()
	{
		if(function_exists('ob_start'))
		{
			if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
			  ob_start(array($this,'pullContent'), 0, PHP_OUTPUT_HANDLER_STDFLAGS ^ PHP_OUTPUT_HANDLER_REMOVABLE);
			} else {
			  ob_start(array($this,'pullContent'), 0, false);
			}
		}
	}
	
	protected function pullContent($buffer)
	{
		return $buffer;
	}
	
	/**
	 * Send All headers
	 * @return void
	 */
	public function send()
	{
		
		$this->prepareHeaders();
		
		// headers have already been sent by the developer
		if (headers_sent()) 
		{
			return;
		}
		
		
		
		if(defined('ALLOW_CROSSDOMAIN') && ALLOW_CROSSDOMAIN)
			header("Access-Control-Allow-Origin: *");
		
		/**
		 * @see http://www.p3pwriter.com/LRN_111.asp
		 *
		 */
		header('P3P:CP="IDC DSP COR ADM DEV TAI PSA PSD IVAi IVDi CONi HIS OUR IND CNT STA"');
		
		if (!$this->headers->has('Date')) 
		{
			$this->setDate(\DateTime::createFromFormat('U', time()));
		}
		
		// headers
		foreach ($this->headers->allPreserveCase() as $name => $values) 
		{
			foreach ($values as $value) 
			{
				header($name.': '.$value, false, $this->statusCode);
			}
		}
	
	
		// status
		header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);

		
		$this->publishSessionAndCookie();
		
		
		// close and ends requisitions
		if (function_exists('fastcgi_finish_request')) 
		{
			fastcgi_finish_request();
		} elseif ('cli' !== PHP_SAPI) 
		{
			static::closeOutputBuffers(0, true);
		}
	}
	
	protected function publishSessionAndCookie()
	{
		SsxSession::publish();
		
		// cookies
		foreach ($this->headers->getCookies() as $cookie)
		{
			if ($cookie->isRaw())
			{
				setrawcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
			} else {
				setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
			}
		}
	}
	
	
	public function prepareHeaders()
	{
		$headers = $this->headers;
		
		if ($this->isInformational() || $this->isEmpty()) 
		{
			$headers->remove('Content-Type');
			$headers->remove('Content-Length');
		} else 
		{
			// Content-type based on the Request
			
			
			$format = $this->contentType;
			
			if (null !== $format && $mimeType = Ssx::$request->getMimeType('html'))
			{
				$headers->set('Content-Type', $mimeType);
			}else{
				$headers->set('Content-Type', $format);
			}
			
			// Fix Content-Type
			$charset = $this->charset ?: 'UTF-8';
			
			$headers->set('Content-Type', $headers->get('Content-Type').'; charset='.$charset);
			
			// Fix Content-Length
			if ($headers->has('Transfer-Encoding')) 
			{
				$headers->remove('Content-Length');
			}
			
			if (Ssx::$request->isMethod('HEAD')) 
			{
				// cf. RFC2616 14.13
				$length = $headers->get('Content-Length');

				if ($length) 
				{
					$headers->set('Content-Length', $length);
				}
			}else{
				//override lenght to avoid wrong lenght
				$length = ob_get_length();
				
				if ($length)
				{
					$headers->set('Content-Length', $length);
				}
			}
		}
		// Fix protocol
		if ('HTTP/1.0' != Ssx::$request->server->get('SERVER_PROTOCOL')) 
		{
			$this->setProtocolVersion('1.1');
		}
		
		// Check if we need to send extra expire info headers
		if ('1.0' == $this->getProtocolVersion() && 'no-cache' == $this->headers->get('Cache-Control')) 
		{
			$this->headers->set('pragma', 'no-cache');
			$this->headers->set('expires', -1);
		}
	}

	
	/**
	 * Set header status code
	 * 
	 * @param int $code
	 * @param string $text
	 * @throws \InvalidArgumentException
	 */
	public function setStatusCode($code, $text = null)
	{
		$this->statusCode = $code = (int) $code;
		if ($this->isInvalid()) {
			throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
		}
		
		if (null === $text) 
		{
			$this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';
			return $this;
		}
		
		{
			$this->statusText = '';
			return $this;
		}
		$this->statusText = $text;
		return $this;
	}
	
	public function headerRedirect($url)
	{
		$this->publishSessionAndCookie();
		
		header("location: ".$url);
		exit;
	}

	
	/**
	 * Sets the HTTP protocol version (1.0 or 1.1).
	 * @param string $version The HTTP protocol version
	 * @return Response
	 */
	public function setProtocolVersion($version)
	{
		$this->version = $version;
	}
	
	/**
	 * Gets the HTTP protocol version.
	 * @return string The HTTP protocol version
	 */
	public function getProtocolVersion()
	{
		return $this->version;
	}
	
	
	/**
	 * get HttpStatus Code i.e 202
	 * @return int
	 * 
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}
	
	
	public function setCharset($charset)
	{
		$this->charset = $charset;
		return $this;
	}

	public function getCharset()
	{
		return $this->charset;
	}
	
	
	public function setContentType($type)
	{
		$this->contentType = Ssx::$request->getMimeType($type);
	}
	
	public function getContentType()
	{
		return $this->contentType;
	}
	
	/**
	 * Returns the Date header as a DateTime instance.
	 *
	 * @return \DateTime A \DateTime instance
	 * @throws \RuntimeException When the header is not parseable
	 */
	public function getDate()
	{
		if (!$this->headers->has('Date')) {
			$this->setDate(\DateTime::createFromFormat('U', time()));
		}
		return $this->headers->getDate('Date');
	}
	/**
	 * Sets the Date header.
	 *
	 * @param \DateTime $date A \DateTime instance
	 * @return Response
	 */
	public function setDate(\DateTime $date)
	{
		$date->setTimezone(new \DateTimeZone('UTC'));
		$this->headers->set('Date', $date->format('D, d M Y H:i:s').' GMT');
		return $this;
	}
	
	/**
	 * Is response invalid?
	 *
	 * @return bool
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 */
	public function isInvalid()
	{
		return $this->statusCode < 100 || $this->statusCode >= 600;
	}
	
	/**
	 * Is response informative?
	 * @return bool
	 */
	public function isInformational()
	{
		return $this->statusCode >= 100 && $this->statusCode < 200;
	}
	
	/**
	 * Is response successful?
	 * @return bool
	 */
	public function isSuccessful()
	{
		return $this->statusCode >= 200 && $this->statusCode < 300;
	}
	
	/**
	 * Is the response a redirect?
	 * @return bool
	 */
	public function isRedirection()
	{
		return $this->statusCode >= 300 && $this->statusCode < 400;
	}
	
	/**
	 * Is there a client error?
	 * @return bool
	 */
	public function isClientError()
	{
		return $this->statusCode >= 400 && $this->statusCode < 500;
	}
	
	/**
	 * Was there a server side error?
	 * @return bool
	 */
	public function isServerError()
	{
		return $this->statusCode >= 500 && $this->statusCode < 600;
	}
	
	/**
	 * Is the response OK?
	 * @return bool
	 */
	public function isOk()
	{
		return 200 === $this->statusCode;
	}
	
	/**
	 * Is the response forbidden?
	 * @return bool
	 */
	public function isForbidden()
	{
		return 403 === $this->statusCode;
	}
	
	/**
	 * Is the response a not found error?
	 * @return bool
	 */
	public function isNotFound()
	{
		return 404 === $this->statusCode;
	}
	
	/**
	 * Is the response a redirect of some form?
	 *
	 * @param string $location
	 * @return bool
	 */
	public function isRedirect($location = null)
	{
		return in_array($this->statusCode, array(201, 301, 302, 303, 307, 308)) && (null === $location ?: $location == $this->headers->get('Location'));
	}
	
	/**
	 * Is the response empty?
	 * @return bool
	 */
	public function isEmpty()
	{
		return in_array($this->statusCode, array(204, 304));
	}
	
	public static function closeOutputBuffers($targetLevel, $flush)
	{
		$status = ob_get_status(true);
		$level = count($status);
		// PHP_OUTPUT_HANDLER_* are not defined on HHVM 3.3
		$flags = defined('PHP_OUTPUT_HANDLER_REMOVABLE') ? PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE) : -1;
		
		while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || $flags === ($s['flags'] & $flags) : $s['del'])) 
		{
			if ($flush) {
				ob_end_flush();
			} else {
				ob_end_clean();
			}
		}
	}
}