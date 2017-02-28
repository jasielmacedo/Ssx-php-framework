<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
class SsxRecovery
{	
	public static function checkBase()
	{
		self::checkTables();
		self::checkProjectExists();
	}
	
	private static function checkProjectExists()
	{
		if(!Ssx::$link->check_connection())
			return false;
		
		$statement = Ssx::$link->prepare("SELECT * FROM ssx_project WHERE id = '".Ssx::$project."'");
		$project = Ssx::$link->getone($statement);
		
		if(!$project)
		{
			$admin_id = SsxUtils::guid();
			$admin_group_id = SsxUtils::guid();
			
			$guest_id = SsxUtils::guid();
			$guest_group_id = SsxUtils::guid();
			
			$project_id = (int)Ssx::$project;
						
			// inserindo projeto
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_project` VALUES(".$project_id.", 1)");
			Ssx::$link->cmd($statement);
			
			// inserindo administrador
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user` VALUES('".$admin_id."','".$project_id."', '".$admin_id."', NOW( ) , '".$admin_id."', NOW( ) , '0', 'Admin', 'administrator', 'admin@".domain_name(false)."' ,'', '1')");
			Ssx::$link->cmd($statement);
			
			// inserindo visitante
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user` VALUES('".$guest_id."','".$project_id."', '".$admin_id."', NOW( ) , '".$admin_id."', NOW( ) , '0', 'Visitante', 'guest', 'guest@".domain_name(false)."' ,'', '1')");
			Ssx::$link->cmd($statement);
			
			// senha do administrador
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user_pd` VALUES('".$admin_id."', '".$admin_id."', NOW( ) , '1', '$2a$08$.adCJuWiqk9P6dl31bUNGu/ia2kmuLudllkE.kzyjk/OYgbnsYxJ.', '')");
			Ssx::$link->cmd($statement);
			
			// senha do guest
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user_pd` VALUES('".$guest_id."', '".$admin_id."', NOW( ) , '1', '$2a$08$.adCJuWiqk9P6dl31bUNGu/ia2kmuLudllkE.kzyjk/OYgbnsYxJ.', '')");
			Ssx::$link->cmd($statement);
			
			// grupo de admin
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_groups` VALUES('".$admin_group_id."','".$project_id."', '".$admin_id."', NOW( ),'".$admin_id."', NOW( ), '0', 'admin', 'adminitracao de usuario',0, 1)");
			Ssx::$link->cmd($statement);
			
			// grupo de visitantes
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_groups` VALUES('".$guest_group_id."','".$project_id."', '".$admin_id."', NOW( ),'".$admin_id."', NOW( ), '0', 'guest', 'visitantes do sistema',2, 1)");
			Ssx::$link->cmd($statement);
			
			// relacao grupo admin / admin
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user_groups` VALUES('".$admin_id."','".$admin_group_id."', '".$admin_id."', NOW( ), '".$admin_id."', NOW( ))");
			Ssx::$link->cmd($statement);
			
			// relacao grupo guest / guest
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_user_groups` VALUES('".$guest_id."','".$guest_group_id."', '".$admin_id."', NOW( ), '".$admin_id."', NOW( ))");
			Ssx::$link->cmd($statement);
			
			// salvando permissoes do admin
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_acl_group` VALUES('".SsxUtils::guid()."', '".$admin_id."', NOW( ), '".$admin_id."', NOW( ), '".$admin_group_id."', 'all_access');");
			Ssx::$link->cmd($statement);

			
			$data_config = new SsxProjectData();
			$data_config->ad_id = $admin_id;
			$data_config->ad_g_id = $admin_group_id;
			$data_config->g_id = $guest_id;
			$data_config->g_g_id = $guest_group_id;
			
			// salvando configs
			$statement = Ssx::$link->prepare("INSERT INTO `ssx_config` VALUES('".SsxUtils::guid()."','".$project_id."',NOW(), '".$admin_id."',NOW(), '".$admin_id."','".SsxConfig::SSX_DATA_SET."','".serialize($data_config)."')");
			Ssx::$link->cmd($statement);
			
			die("Database updated. Refresh this page to continue");
		}
	}
	
	private static function checkTables()
	{		
		if(!Ssx::$link->check_connection())
			return false;
		
		$statement = Ssx::$link->prepare("SHOW TABLES");
		$onTables = Ssx::$link->get($statement);	
			
		$notFound = array();
		
		if($onTables)
		{
			$tables = self::$tables_script;
			$founded = array();
			
			foreach($onTables as $row)
			{
				foreach($row as $table)
				{
					$founded[$table] = 1;
				}
			}
			
			foreach($tables as $table)
			{
				
				if(!array_key_exists($table, $founded))
					$notFound[] = $table;
			}
		}else{
			$notFound = self::$tables_script;
		}
		
		if($notFound)
		{		
			foreach($notFound as $row)
			{
				if(defined("DB_ERROR_SHOW_WARNINGS") && DB_ERROR_SHOW_WARNINGS)
					print "ERROR: Banco de Dados comprometido. Tabelas importantes n&atilde;o foram encontradas.";
				die;
			}
		}
	}
	
	private static $tables_script = array(
			"ssx_project",
			"ssx_user",
			"ssx_user_pd",
			"ssx_session_log",
			"ssx_user_token",
			"ssx_groups",
			"ssx_user_groups",
			"ssx_acl_group",		
			"ssx_plugins",
			"ssx_config",
			"ssx_pages",
			"ssx_tags",
			"ssx_tags_object"
				
	);
}
