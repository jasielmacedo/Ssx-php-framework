<?php


class SsxSessionHandle
{
	private $save_path;
	private $session_name;
	
	private $prefix = "ssx_sess";
	
	private $opened = false;
	
	public function __construct($save_path, $session_name)
	{
		$this->open($save_path, $session_name);
		
		$rand = rand(0, 100);
		if($rand === 99)
			$this->gc(1440);
	}	
	
	public function open($save_path, $session_name)
	{
		$this->save_path = $save_path;
		$this->session_name = $session_name;
		$this->opened = true;
	}
	
	public function close()
	{
		$this->open = false;
		return true;
	}
	
	public function destroy($id)
	{		
		if(!$this->opened)
			return false;
		
		$sess_file = $this->save_path.'/'.$this->prefix.'_'.$id;
		if(file_exists($sess_file))
			return(@unlink($sess_file));
		
		return true;
	}
	
	public function read($id)
	{
		if(!$this->opened)
			return null;
		
		$sess_file = $this->save_path.'/'.$this->prefix.'_'.$id;
		
		if ($fp = @fopen($sess_file, "r")) 
		{
			$sess_data = @fread($fp, filesize($sess_file));
	    	return ($sess_data);
		}else {
			return null;
		}
	}
	
	public function write($id, $sess_data)
	{
		if(!$this->opened)
			return null;
		
		$sess_file = $this->save_path.'/'.$this->prefix.'_'.$id;
		
		$fp = @fopen($sess_file, "w");
		
		if ($fp) 
		{
			$write = (@fwrite($fp, $sess_data));
			@fclose($fp);
			
			if(!$write)
				die("SSX SESSION ERROR: Não é possível manipular sess&otilde;es. Permiss&atilde;o de escrita desabilitada.");
			return $write;
		} else {
			return (false);
		}
	}
	
	public function gc($maxlifetime)
	{
		$datetime = new \DateTime();
		
		$dh  = opendir($this->save_path);
		
		while (false !== ($filename = readdir($dh))) 
		{
			if("." === $filename || ".." === $filename || "." === $filename[0])
				continue;
			
			if(!function_exists('filemtime'))
				break;
				
			if(\Carbon\Carbon::createFromTimestamp(@filemtime($this->save_path . "/" . $filename))->addSeconds($maxlifetime)->isPast())
			{
				@unlink($this->save_path . "/" . $filename);
			}			
		}
		
		return true;
	}
}