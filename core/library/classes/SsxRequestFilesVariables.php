<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *  
 */

class SsxRequestFilesVariables extends SsxRequestVariables
{
	
	private static $fileKeys = array('error', 'name', 'size', 'tmp_name', 'type');
	
	public function __construct(array $files = array())
	{
		$this->replace($files);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function replace(array $files = array())
	{
		$this->storage = array();
		$this->add($files);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function add(array $files = array())
	{
		foreach ($files as $key => $file) 
		{
			$this->set($key, $file);
		}
	}
	
	/**
	 *	Returns an fixed data array
	 *
	 * @param array $data
	 * @return array
	 */
	protected function setDefaultFormatFileArray($data)
	{
		if (!is_array($data)) 
		{
			return $data;
		}
		
		$keys = array_keys($data);
		sort($keys);
		
		if (self::$fileKeys != $keys || !isset($data['name']) || !is_array($data['name'])) 
		{
			return $data;
		}
		
		$files = $data;
		
		foreach (self::$fileKeys as $k) 
		{
			unset($files[$k]);
		}
		
		foreach ($data['name'] as $key => $name) 
		{
			//recursive correction
			$files[$key] = $this->setDefaultFormatFileArray(array(
					'error' => $data['error'][$key],
					'name' => $name,
					'type' => $data['type'][$key],
					'tmp_name' => $data['tmp_name'][$key],
					'size' => $data['size'][$key],
			));
		}
		return $files;
	}
	
	
}