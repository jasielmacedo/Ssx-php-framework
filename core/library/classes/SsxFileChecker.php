<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

/**
 * Uses FInfo to validate mimeType from file
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 *
 */
class SsxFileChecker
{
	
	protected $fileUrl;
	
	protected $fileInstance;
	
	protected $broken = false;
	
	/**
	 * @see http://php.net/manual/pt_BR/class.finfo.php
	 * 
	 * @param Magic Url File $file
	 * @throws ErrorException
	 * @throws FileNotFoundException
	 * @throws AccessDeniedException
	 */
	public function __construct($file)
	{
		if(!self::isSupported())	
			throw new ErrorException("SsxInfo: Finfo is not supported");
		
		$this->fileUrl = $file;
		
		if(!is_file($this->fileUrl))
			throw new FileNotFoundException($this->fileUrl);
		
		if (!is_readable($this->fileUrl))
			throw new AccessDeniedException($this->fileUrl);
		
			
		if ($finfo = new \finfo(FILEINFO_MIME_TYPE)) {
			$this->fileInstance = $finfo->file($this->fileUrl);
		}else{
			$this->broken;
		}		
	}
	
	public static function isSupported()
	{
		return function_exists('finfo_open');
	}
	
	public function isBroken()
	{
		return $this->broken;
	}
	
	public function getMimeType()
	{
		if($this->isBroken())
			return false;
		
		return $this->fileInstance;
	}
}