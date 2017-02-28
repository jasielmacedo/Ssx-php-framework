<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
defined("SSX") or die;

class SsxPDO
{
	/**
	 * Conexão com o banco de Dados
	 * @var PDO
	 */
	public $con;
	
	private $error_show_warnings = true;
	private $error_die_application = true;
	
	/**
	 * Classe em contrução
	 * @param SsxHosts $host
	 */
	public function __construct(SsxHosts &$host)
	{
		if(!$host)
			die(SSX_ERROR_DB_02);
			
		register_shutdown_function( array( &$this, 'off' ) );
  	
  		if(defined('DB_ERROR_SHOW_WARNINGS'))
    		$this->error_show_warnings = (constant('DB_ERROR_SHOW_WARNINGS'))?true:false;
    	
  		if(defined('DB_ERROR_DROP_APPLICATION'))
    		$this->error_die_application = (constant('DB_ERROR_DROP_APPLICATION'))?true:false;
			
		$this->openConnection($host);
	}
	
	private function openConnection(SsxHosts $host)
	{
		try
		{
			$encoding = constant('SSX_ENCODING');
	    	$encoding = str_replace("-", "", $encoding);
	    	$encoding = strtolower($encoding);
			
	    	
	    	$driver = "";
	    	switch ($host->type)
	    	{
	    		case "postgresql":
	    		case "postgres":
	    		case "postgre":
	    			$driver = "pgsql";
	    		break;
	    		case "mysql":
	    		default:
	    			$driver = "mysql";
	    		break;
	    	}
	    	
	    	
			$this->con = new PDO($driver.":host=" . $host->host . ";dbname=" . $host->database. "; port=".$host->port."; charset=".$encoding, $host->user, $host->pass);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
			
			if(!$this->con || $this->checkConError())
				throw new Exception($this->con->errorInfo(), $this->con->errorCode());
			
		}catch(Exception $e)
		{
			$this->errorException("SSX DATABASE: Não foi possível conectar.");
		}
	}
	
	public function get(PDOStatement &$statement, $one=false, $object=null)
	{
		if(!$this->con || $this->checkConError())
			return false;
			
		if(!$statement)
		{
			 $this->errorException(SSX_ERROR_DB_04);  
		}else
		{
			$statement->execute();

			if($statement && !$this->statementCheckError($statement) && $statement->rowCount() > 0)
			{
				if($object && class_exists($object))
				{
					if($one)
						return $statement->fetchObject($object);
						
					$return = array();
						
					while($row = $statement->fetchObject($object))
					{
						$return[] = $row;
					}
					return $return;
				}else{
					if($one)
						return $statement->fetch(PDO::FETCH_ASSOC);
					
					$return = array();
					
					while($row = $statement->fetch(PDO::FETCH_ASSOC))
					{
						$return[] = $row;
					}				
					return $return;
				}
			}else
			{
				if($this->statementCheckError($statement))
				{
					 $error_msg = $statement->errorInfo();
					 $msg = SSX_ERROR_DB_05."<br />".$error_msg[2]."<br />".$statement->queryString;
					 $this->errorException($msg);
				}
			}
		}
		return false;
	}
	
	public function cmd(PDOStatement &$statement)
	{
		if(!$this->con || $this->checkConError())
			return false;
			
		if(!$statement)
		{
     		$this->errorException(SSX_ERROR_DB_04);
		}else
		{
			$statement->execute();
			
			if($statement && !$this->statementCheckError($statement) || $statement->rowCount() > 0)
				return true;
			else
			{
				 if($this->statementCheckError($statement))
				 {
				 	$error = $statement->errorInfo();
				 	$this->errorException(SSX_ERROR_DB_05."<br />".$error[2]."<br />".$statement->queryString);
				 }
			}
		}
		return false;
	}
	
	private function errorException($error)
	{
		if($this->error_show_warnings || $this->error_die_application)
			print $error;
			
		if($this->error_die_application)
			die;
	}
	
	private function checkConError()
	{
		if(!$this->con->errorCode() || $this->con->errorCode() === "00000")
			return false;
		return true;
	}
	
	private function statementCheckError(PDOStatement &$statement)
	{
		if(!$statement->errorCode() || $statement->errorCode() === "00000")
			return false;
		return true;
	}
	
	public function off()
	{
		unset($this->con);	
	}	
}