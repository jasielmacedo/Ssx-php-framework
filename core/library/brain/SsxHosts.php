<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

defined("SSX") or die;

class SsxHosts
{
	public $user;
	public $pass;
	public $host;
	public $database;
	public $type;
	public $port;
	
	public function SsxHosts(&$_user, &$_pass, &$_host, &$_database, &$_type,$_port="3306",&$keypair)
	{
		if(!$keypair)
			die('SSX HOSTS: Impossivel conectar sem a chave'); 
		
		$this->user = trim(SsxProtect::decrypt($_user, $keypair)); 
		$this->pass = trim(SsxProtect::decrypt($_pass, $keypair)); 
		$this->host = trim(SsxProtect::decrypt($_host, $keypair)); 
		$this->database = trim(SsxProtect::decrypt($_database, $keypair));
		
		$this->type = strtolower($_type);
		$this->port = $_port;
		
	}
}