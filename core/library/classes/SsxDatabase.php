<?php 
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 */

defined("SSX") or die;

class SsxDatabase 
{
	/**
	 * 
	 * SsxPDO class default
	 * @var SsxPDO
	 */
	private $link;
	
	private $auto;
	
	/**
	 * Armazena qual foi o ultimo comando sql executado
	 * @var PDOStatement
	 */
	public $last_query;
	
	public $queries = array();
	
	public function SsxDatabase(SsxHosts $Hosts,$transation=true)
	{
		
      	$this->createLink($Hosts);   
		
      	$this->auto = false;  
      	
		if($this->check_connection())
		{
	        if(isset($transation))
	        {
	 	      $this->auto=true;
	  	    }else
	  	    {
		      $this->auto=false;
		    }        
       		return true;
        }else{
        	return false;        
        } 
	}
	
	public function changeTransition($auto)
	{
		$this->auto = $auto;
	}
	
	private function createLink(SsxHosts &$hosts)
	{
		require_once(LIBPATH . "classes/database/SsxPDO.php");
		
		$this->link = new SsxPDO($hosts);
		
		//$nobackslash = $this->prepare('SET SQL_MODE="NO_BACKSLASH_ESCAPES"');
		//$this->link->cmd($nobackslash);
	}
	
	public function check_connection()
	{
		if(!$this->link || !$this->link->con)
			return false;
		return true;		
	}
	
	public function prepare($sql, $driver_options=array())
	{
		if($this->check_connection())
			return $this->link->con->prepare($sql,$driver_options);
		return false;
	}
	
	public function lastId($string_name=null)
	{
		if($this->check_connection())
			return $this->link->con->lastInsertId($string_name);
		return false;
	}
	
	public function get(PDOStatement &$sql,$object=null)
	{   
	  if(!$sql)
		die(SSX_ERROR_DB_04);
      
	  array_push($this->queries, $sql->queryString);
	  
      return $this->link->get($sql,false,$object);
    }
    
	public function getone(PDOStatement &$sql, $object=null)
	{
	  if(!$sql)
		die(SSX_ERROR_DB_04);
	  
	  array_push($this->queries, $sql->queryString);
      
      return $this->link->get($sql,true,$object);
    }
    
	public function cmd(PDOStatement &$sql)
	{ 
	  if(!$sql)
		die(SSX_ERROR_DB_04);
		
	  array_push($this->queries, $sql->queryString);
	  
      if($this->auto)
      {
        $this->transaction();
        
        $cmd = $this->link->cmd($sql); 
               
	    if($cmd)
	    {	      
	      return $this->commit();
	    }else
	    {
	      $this->rollback();
	      return false;
	    } 
      }else
      {        
        return $this->link->cmd($sql);
      }
    }
	
	public function transaction()
    {
      return $this->link->con->beginTransaction();
    }
    
	public function commit()
	{
	      return $this->link->con->commit();
	}    
    
    public function rollback()
    {
      return $this->link->con->rollback();
    }

    public function off()
    {
      return $this->link->off();
    }
}