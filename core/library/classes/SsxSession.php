<?php
/**
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class SsxSession
{
	/**
	 * Session Manager Handle
	 * @var SsxSessionManager
	 */
	private static $manager = null;
	
	public static function start()
	{
		if(null === self::$manager)
			self::$manager = new SsxSessionManager();
		
	}
	
	public static function regenerateSessionId()
	{
		return self::$manager->generateSessionId();
	}
	
	public static function get($key)
	{
		return self::$manager->get($key);
	}
	
	public static function set($key, $value)
	{
		self::$manager->set($key, $value);
	}
	
	public static function remove($key)
	{
		self::$manager->remove($key);
	}
	
	public static function getSessionID()
	{
		return self::$manager->getId();
	}
		
	public static function publish()
	{
		self::$manager->save();
	}
}