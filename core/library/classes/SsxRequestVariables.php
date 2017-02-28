<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.1
 * @since 12/05/2015
 * 
 */

class SsxRequestVariables implements \IteratorAggregate, \Countable
{
	/**
	 * Storage content variable
	 * @var unknown
	 */
	protected $storage;
	
	/**
	 * Initialize storage variable
	 * @param array $variables
	 */
	public function __construct(array $variables = array())
	{
		$this->storage = $variables;
	}
	
	/**
	 * Returns an array with all stored content
	 * @return array|mixed
	 */
	public function getStorage()
	{
		return $this->storage;
	}
	
	/**
	 * Alias to getStorage
	 */
	public function all()
	{ 
		return $this->getStorage();
	}
	
	/**
	 * Return all keys stored
	 * @return array
	 */
	public function keys()
	{
		return array_keys($this->storage);
	}
	
	/**
	 * Add new content
	 * @param array $variables
	 */
	public function add(array $variables = array())
	{
		$this->storage = array_replace($this->storage, $variables);
	}
	
	/**
	 * Remove an key stored
	 * @param unknown $key
	 */
	public function remove($key)
	{
		if($this->has($key))
		{
			unset($this->storage[$key]);
		}
	}
	
	/**
	 * Replace content stored
	 * @param array $parameters
	 */
	public function replace(array $parameters = array())
    {
        $this->storage = $parameters;
    }
	
    /**
     * Get value of key
     * @param string $key
     * @param mixed $default
     * @return string|mixed
     */
	public function get($key, $default = null)
	{
		return array_key_exists($key, $this->storage) ? $this->storage[$key] : $default;
	}
	
	/**
	 * Set an especific key to value
	 * @param string $key
	 * @param mixed $value
	 */
	public function set($key, $value)
	{
		$this->storage[$key] = $value;
	}
	
	/**
	 * Check if key exists
	 * @param unknown $key
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->storage);
	}
	
	/**
	 * Compare two keys
	 * @param string $keyA
	 * @param string $keyB
	 * @return bool
	 */
	public function isEqual($keyA, $keyB)
	{
		return ($this->get($keyA) == $this->get($keyB));
	}
	
	
	/**
	 * Filter indicated key.
	 *
	 * @param string $key     Key.
	 * @param mixed  $default Default = null.
	 * @param int    $filter  FILTER_* constant.
	 * @param mixed  $options Filter options.
	 *
	 * @see http://php.net/manual/en/function.filter-var.php
	 *
	 * @return mixed
	 */
	public function filter($key, $default = null, $filter = FILTER_DEFAULT, $params = array())
	{
		$value = $this->get($key, $default);
		
		if (!is_array($params) && $params) 
		{
			$params = array('flags' => $params);
		}
		
		
		if (is_array($value) && !isset($params['flags'])) 
		{
			$params['flags'] = FILTER_REQUIRE_ARRAY;
		}
		return filter_var($value, $filter, $params);
	}
	
	
	/**
	 * Returns the number of stored variables.
	 * @return int
	 */
	public function lenght()
	{
		return count($this->storage);
	}
	
	public function count()
	{
		return $this->lenght();
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->storage);
	}
}