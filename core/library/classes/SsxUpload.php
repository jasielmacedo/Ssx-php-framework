<?php
/**
 * 
 * Classe de upload simples do Ssx
 * Upgrade no sistema de verificação de arquivo
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.2
 *
 */

defined("SSX") or die;

class SsxUpload extends SsxModels
{
	private $dir_upload = "";
	
	/**
	 * Ao contruir indicar o diretório na qual será salvo o arquivo
	 * O caminho sempre será incluído depois de LOCALPATH se o $autocomplete for igual a true
	 * @param string $dir
	 * @param bool $autocomplete
	 */
	public function __construct($dir, $autocomplete=true)
	{

		if($autocomplete)
		{
			if(substr($dir,0,1) == "/")
			$dir = substr($dir, 1,strlen($dir)-1);
			
			$this->dir_upload = LOCALPATH . $dir;
		}else
			$this->dir_upload = $dir;
			
		if(substr($this->dir_upload, strlen($this->dir_upload)-1,1) == "/")
			$this->dir_upload = substr($this->dir_upload, 0,strlen($this->dir_upload)-1);
			
		if(!file_exists($this->dir_upload))
			die('SsxUpload: Dir not found');
	}
	
	/**
	 * Upload simples de imagem
	 * suporte png,jpeg e gif
	 * @param $_FILES $file
	 */
	public function uploadImage($file)
	{
		if(!is_array($file))
			return false;
		
		$newname = parent::create_guid();
		
		$fileExtension = "";
		
		if(!$this->checkForImage($file,$fileExtension))
			return false;
			
		if($file['size'] < 5000 || $file['size'] > 3000000)
			return false;
		
		$new_file_name = $newname . ".".$fileExtension;
		try
		{
			if(!@move_uploaded_file($file['tmp_name'],$this->dir_upload . "/" . $new_file_name))
			{
				@copy($file['tmp_name'],$this->dir_upload . "/" . $new_file_name);
			}
			
			if(!file_exists($this->dir_upload . "/" . $new_file_name))
				throw new Exception("Erro ao subir arquivo");
			
			return $new_file_name;
		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}
	
	/**
	 * 
	 * Analisa o arquivo enviado antes de confirmar se pode ser realizado o upload
	 * @param $_FILES $file
	 * @see http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
	 * 
	 */
	private function analysisFile($file)
	{
		$SsxFileChecker = new SsxFileChecker($file['tmp_name']);
		$mime = $SsxFileChecker->getMimeType();
		if(!$mime)
			return null;
		
		$fileExtension = null;
		switch ($mime)
		{
			case "image/jpeg": $fileExtension = "jpg"; break;
			case "image/gif": $fileExtension = "gif"; break;
			case "image/png": $fileExtension = "png"; break;
			case "image/bmp": $fileExtension = "bmp"; break;
			case "application/msword": $fileExtension = "doc"; break;
			case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":  $fileExtension = "docx"; break;
			case "application/pdf": $fileExtension = "pdf"; break;
			case "text/plain": $fileExtension = "txt"; break;
			case "application/vnd.ms-excel": $fileExtension = "xls"; break;
			case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $fileExtension = "xlsx"; break;
			case "application/rtf": $fileExtension = "rtf"; break;
			case "application/vnd.oasis.opendocument.text": $fileExtension = "odt"; break;
			case "application/vnd.oasis.opendocument.spreadsheet": $fileExtension = "ods"; break;
			case "application/vnd.oasis.opendocument.presentation": $fileExtension = "odp"; break;
			case "application/vnd.ms-powerpoint": $fileExtension = "ppt"; break;
			case "application/vnd.openxmlformats-officedocument.presentationml.presentation": $fileExtension = "pptx"; break;
			case "application/zip": $fileExtension = "zip"; break;
			case "application/x-rar-compressed": $fileExtension = "rar"; break;
			case "application/x-msdownload": $fileExtension = "exe"; break;
		}
			
   		return $fileExtension;
	}
	
	/**
	 * 
	 * Analisa de o arquivo enviado é realmente uma imagem do tipo: png, jpg ou gif
	 * @param $_FILES $file
	 */
	private function checkForImage($file, &$fileExtension)
	{
		$ext = array('jpg', 'gif', 'png');
		
		$fileExtension = $this->analysisFile($file);
		if(null === $fileExtension || false === array_search($fileExtension,$ext))
			return false;

		return true;
	}
	
	/**
	 * Upload simples de arquivos
	 * 
	 * @param array $file
	 * @param extAllow define quais extensões de arquivos serão permitidas
	 * @return string|bool
	 */
	public function uploadFile($file, $extAllow=array())
	{
		if(!is_array($file))
			return false;
		
		$newname = parent::create_guid();
		
		if(!$extAllow)
		{
			/*
			 * Extensões:
			 * doc,docx,xls,xlsx,ppt,pptx,rtf - Microsoft Office
			 * pdf - Adobe
			 * txt - default
			 * odt,ods,odp - BrOffice
			 */
			$extAllow = array('doc','pdf','txt', 'xls','xlsx','docx','rtf','odt','ods','odp','ppt','pptx','zip');
		}
		
		$fileExtension = $this->analysisFile($file);
		
		if(null === $fileExtension || false === array_search($fileExtension,$extAllow))
			return false;
		
		$new_file_name = $newname . "." . $fileExtension;
		
		try
		{
			if(!@move_uploaded_file($file['tmp_name'],$this->dir_upload . "/" . $new_file_name))
			{
				@copy($file['tmp_name'],$this->dir_upload . "/" . $new_file_name);
			}
			
			if(!file_exists($this->dir_upload . "/" . $new_file_name))
				throw new Exception("Erro ao subir arquivo. Verifique se a pasta indicada possui permissão de escrita.");
			
			return $new_file_name;
		}catch(Exception $e)
		{
			return false;
		}
		return false;
	}
}