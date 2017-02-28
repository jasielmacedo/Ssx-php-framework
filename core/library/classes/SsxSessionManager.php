<?php
/**
 * 
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 * 
 */

class SsxSessionManager implements \ArrayAccess,\Countable, \Serializable
{
	/**
	 * Define if session manager as been started
	 * @var bool
	 */
	protected $started = false;
	
	/**
	 * Session Id
	 * @var string
	 */
	protected $sessionId = null;
	
	/**
	 * Session Name
	 * @var string
	 */
	protected $sessionName = "SSID";
	
	/**
	 * Session Handle Manipulator
	 * @var SsxSessionHandle
	 */
	protected $handle;
	
	/**
	 * Session iterator
	 * @var array
	 */
	protected $storage;
	
	/**
	 * Session hour timeout to destroy cookie
	 * @var integer
	 */
	protected $sessionHourlifeTime = 2;
	
	
	/**
	 * Path to the current session
	 * @var string
	 */
	private $session_path;
	
	public function __construct()
	{
		$this->handle = new SsxSessionHandle(COREPATH . "storage/session/",$this->sessionName);	
		$this->instantiate();
	}
	
	protected function instantiate()
	{
		$recovered = Ssx::$request->cookie->get($this->sessionName);
		if(null === $recovered)
			$this->generateSessionId();
		else
			$this->setId($recovered);
		
		$this->getStoredSession();
		
		$basePath = Ssx::$request->getBaseUrl();
		if("" === $basePath)
			$basePath = "/";
		
		$this->session_path = $basePath;
	}
	
	protected function getStoredSession()
	{
		$this->storage = array();
		
		if(null !== ($session_data = $this->handle->read($this->sessionId)))
		{
			$this->storage = @unserialize($session_data);
		}else{
			$this->generateSessionId();
		}
	}
	
	public function registerSessionOnResponse()
	{
		Ssx::$response->headers->setCookie(
				new SsxCookie(
						$this->sessionName,
						$this->sessionId,
						\Carbon\Carbon::now()->addHours(2),
						$this->session_path,
						false,
						false));
	}
	
	/**
	 * Save all session data;
	 */
	public function save()
	{
		// recover session data
		$data = @serialize($this->storage);
		
		$this->handle->write($this->sessionId,$data);
		
		// create a cookie to persistent data
		$this->registerSessionOnResponse();
		
		// after this you cannot add or edit session data
		$this->handle->close();
	}
	
	/**
	 * Return all data session stored
	 * Better to access
	 */
	public function all()
	{
		return $this->storage;
	}
	
	/**
	 * Get session key stored
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if(array_key_exists($key, $this->storage))
			return $this->offsetGet($key);
		return null;
	}
	
	/**
	 * Set value to a key on session
	 * @param string $key
	 * @param mixed $value
	 */
	public function set($key, $value)
	{
		return $this->offsetSet($key, $value);
	}
	
	/**
	 * Remove a stored session information
	 * @param string $key
	 */
	public function remove($key)
	{
		if(array_key_exists($key, $this->storage))
			$this->offsetUnset($key);
	}
	
	/**
	 * Get Id of Session
	 * @return string
	 */
	public function getId()
	{
		return $this->sessionId;
	}
	
	/**
	 * Set Id of the session
	 * @param string $id
	 */
	public function setId($id)
	{
		if(null !== $this->sessionId)
			$this->handle->destroy($this->sessionId);
		$this->sessionId = $id;
	}
	
	/**
	 * Generate new id for the session
	 */
	public function generateSessionId()
	{
		$id = SsxString::getRandomString(48,false);
		$this->setId($id);
	}
	
	/**
	 * Get name of the session
	 * Used to cookie information in browser
	 * @return string
	 */
	public function getName()
	{
		return $this->sessionName;
	}
	
	/**
	 * Set name of the session
	 * @param string $new
	 */
	public function setName($new)
	{
		$this->sessionName = $new;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet($offset, $value) 
	{
		if(null === $offset)
			throw new \InvalidArgumentException('Session storage key cannot be null');
		
		$this->storage[$offset] = $value;
	}
	
	/**
	 * {@inheritDoc}
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists($offset) 
	{
		return isset($this->storage[$offset]);
	}
	
	/**
	 * {@inheritDoc}
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset($offset) 
	{
		unset($this->storage[$offset]);
	}
	
	/**
	 * {@inheritDoc}
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($offset) 
	{
		return isset($this->storage[$offset]) ? $this->storage[$offset] : null;
	}
	
	/**
	 * Count session instance
	 */
	public function count()
	{
		return count($this->storage);
	}
	
	/**
	 * Allows to serialize this instance
	 */
	public function serialize() 
	{
		return serialize($this->storage);
	}
	
	/**
	 * Disallow to serialize this instance
	 * @param unknown $data
	 */
	public function unserialize($data) 
	{
		$this->storage = unserialize($data);
	}
}