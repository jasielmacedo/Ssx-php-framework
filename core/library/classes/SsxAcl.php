<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 02/05/2012
 * 
 */

defined("SSX") or die;

class SsxAcl extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_acl_group";
	
	public $fields = array(
		'id'=>'string',
		'created_by'=>'string',
		'date_created'=>'datetime',
		'modified_by'=>'string',
		'date_modified'=>'datetime',
		'group_id'=>'string',
		'permissions'=>'string'
	);
	
	private $_cache_dir;
	
	public static $rules;
	
	public function __construct()
	{
		parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data);
	}
	
	public function getByGroup($group_id)
	{
		return parent::filterData(array('group_id'=>$group_id), true);
	}
	
	/**
	 * Lista todos os modulos e actions que tem no projeto
	 * Tanto dentro do admin como também no proprio projeto em sí
	 * para configurar o sistema de acl partindo das actions.
	 * 
	 * 
	 */
	public function getModulesAndActions()
	{
		if($this->_cache_dir)
			return $this->_cache_dir;
		
		$pathInfo_project = false;
		$pathInfo_admin = false;
		
		if(defined('IS_ADMIN'))
		{
			if(!defined('ADMIN_ONLY') || !ADMIN_ONLY)
				$pathInfo_project = PROJECTPATH;
			$pathInfo_admin = LOCALPATH;
		}else
		{
			$pathInfo_project = LOCALPATH;
			if(defined('ADMIN_EXISTS') && ADMIN_EXISTS)
			{
				$pathInfo_admin = LOCALPATH . ADMIN_FOLDER . "/";
			}
		}	

		$returnData = array();
		
		if($pathInfo_project)
		{
			$projectInfo = $this->getModulesByDir($pathInfo_project . "modules/");
			if($projectInfo)
				$returnData['project'] = $projectInfo;
		}
		
		if($pathInfo_admin)
		{
			$adminInfo = $this->getModulesByDir($pathInfo_admin . "modules/");
			if($adminInfo)
				$returnData['admin'] = $adminInfo;
		}
		$this->_cache_dir = $returnData;	
		
		return $returnData;
	}
	
	public function defaultPermission()
	{
		$modulesAndActions = $this->getModulesAndActions();
		if(!is_array($modulesAndActions) || !$modulesAndActions)
			return false;
			
		foreach($modulesAndActions as $local => $pos)
		{
			$modulesAndActions[$local]['_access'] = true;
			foreach($pos['modules'] as $modules => $actions)
			{					
				foreach($actions as $act)
				{
					$action_permissions = array();
					foreach($act as $action)
					{
						if(($modules == "Auth" && ($action == "login" || $action == "logout")))
							$action_permissions[$action] = true;
						else
							$action_permissions[$action] = false;
					}
					
					$modulesAndActions[$local]['modules'][$modules]['actions'] = $action_permissions;
				}
				
			}
		}
		return $modulesAndActions;
	}
	
	public function defaultRules()
	{
		$rules = SsxAcl::$rules;
		if(!$rules)
		{
			$rules = SsxConfig::get(SsxConfig::SSX_ACL_RULES,'json');
			SsxAcl::$rules = $rules;
		}	
		
		$ruleAccess = array();

		if($rules)
		{
			foreach($rules as $rule)
			{
				$ruleAccess[$rule] = false;
			}
		}
		return $ruleAccess;
	}
	
	public function setPermission($groupPermissions, $other_group_permissions=null)
	{	
		if(!is_array($groupPermissions) && $groupPermissions != "all_access")
			return false;
			
		if($other_group_permissions)
			$modulesAndActions = $other_group_permissions;
		else 
			$modulesAndActions = $this->defaultPermission();

		
		foreach($modulesAndActions as $local => $pos)
		{
			if(is_array($groupPermissions) && isset($groupPermissions[$local]['_access']) && $groupPermissions[$local]['_access'])
			{
				if($modulesAndActions[$local]['_access'] != $groupPermissions[$local]['_access'])
					$modulesAndActions[$local]['_access'] = true;
				else
					$modulesAndActions[$local]['_access'] = $groupPermissions[$local]['_access'];
			}else
				$modulesAndActions[$local]['_access'] = true;
			
			foreach($pos['modules'] as $modules => $actions)
			{					
				foreach($actions as $act)
				{
					$action_permissions = array();
					foreach($act as $action => $value)
					{
						if(is_array($groupPermissions) && isset($groupPermissions[$local]['modules'][$modules]['actions'][$action]) && $groupPermissions[$local]['modules'][$modules]['actions'][$action])
						{
							if( $modulesAndActions[$local]['modules'][$modules]['actions'][$action] != $groupPermissions[$local]['modules'][$modules]['actions'][$action])
								$modulesAndActions[$local]['modules'][$modules]['actions'][$action] = true;
							else
							 	$modulesAndActions[$local]['modules'][$modules]['actions'][$action] = $groupPermissions[$local]['modules'][$modules]['actions'][$action];
							
						}else if($groupPermissions == "all_access")
						{
							$modulesAndActions[$local]['modules'][$modules]['actions'][$action] = true;
						}
					}
					
				}
				
			}
		}
		
		return $modulesAndActions;
	}
	
	public function setRules($rules, $other_rules=null)
	{
		if(!is_array($rules) && $rules != "all_access")
			return $this->defaultRules();
		
		if($other_rules)
			$defaultRules = $other_rules;
		else
			$defaultRules = $this->defaultRules();
		
		foreach($defaultRules as $key => $rule)
		{
			if(is_array($rules) && isset($rules[$key]) && $rules[$key])
			{
				if($defaultRules[$key] != $rules[$key])
					$defaultRules[$key] = true;
				else
					$defaultRules[$key] = $rules[$key];
			}else if($rules == "all_access")
			{
				$defaultRules[$key] = true;
			}
		}
		
		return $defaultRules;
	}
	
	public static function checkRule($rule)
	{
		$rules = SsxUsers::getRules();
		if(!is_array($rules))
			return false;
		
		if(isset($rules[$rule]) && $rules[$rule])
			return true;
		
		return false;
	}
	
	public static function checkPermissionForLocal($local)
	{
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;
			
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'])
			return true;
			
		return false;
	}
	
	public static function checkPermissionForModule($module="Home", $local="project")
	{
		
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;
		
		$module = ucfirst($module);
		if($module == "Auth" && $local == "admin")
			return true;
			
				
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'])
		{	
			if(isset($permissions[$local]['modules'][$module]['actions']) && $permissions[$local]['modules'][$module]['actions'])
			{
				foreach($permissions[$local]['modules'][$module]['actions'] as $actions)
				{
					if($actions === true)
						return true;
				}
			}
		}
			
		return false;
	}
	
	public static function checkPermissionForAction($module="Home", $action="index", $local = "project")
	{
		$permissions = SsxUsers::getPermission();
		if(!is_array($permissions))
			return false;

		$module = ucfirst($module);
		if($module == "Auth" && $action == "login" && $local == "admin")
			return true;

			
		if(isset($permissions[$local]['_access']) && $permissions[$local]['_access'])
		{	
			if(isset($permissions[$local]['modules'][$module]) && $permissions[$local]['modules'][$module])
			{
				if(isset($permissions[$local]['modules'][$module]['actions'][$action]) && $permissions[$local]['modules'][$module]['actions'][$action])
				{
					return true;
				}
			}
		}
			
		return false;
	}
	
	/**
	 *
	 * Retorna as permissões do grupo
	 * Caso não as encontre, retorna a permissão padrão para todos os grupos que não possuem permissões setadas
	 * que só permite acesso a home e ao login
	 * 
	 * @return array
	 */
	public function getPermissionByGroup($group_id)
	{		
		$data = $this->getByGroup($group_id);
		
		
		if(!$data)
			return array('access'=>$this->defaultPermission(),'rules'=>$this->defaultRules());
			
		$permissions = $data['permissions'];
		if(!$permissions)
			return array('access'=>$this->defaultPermission(),'rules'=>$this->defaultRules());
			
		if($permissions == "all_access")
			return array('access'=>$this->setPermission($permissions), 'rules'=>$this->setRules($permissions));	
		
		try
		{
			$permissions = @unserialize($permissions);
			
			if(!$permissions)
				throw new Exception("Erro");
			
		}catch(Exception $e)
		{
			return array('access'=>$this->defaultPermission(),'rules'=>$this->defaultRules());;
		}
			
		return array('access'=>$this->setPermission($permissions['access']), 'rules'=>$this->setRules($permissions['rules']));		
	}
	
	/**
	 * 
	 * Mescla todas as permissões que o usuário tem em cada grupo que ele pertence
	 * @param array $groups
	 * @throws Exception
	 * TODO Acrescentar merge para regras de acesso
	 */
	public function mergePermissionByGroups($groups)
	{
		$merging_permissions = $this->defaultPermission();
		
		if(!$groups)
			return $merging_permissions;
		
			
		foreach($groups as $group_id)
		{
			$data = $this->getByGroup($group_id['id']);
			
			$this_permissions = array();
		
			if(!$data || !$data['permissions'])
			{
				continue;
			}else if(isset($data['permissions']) && $data['permissions'] == "all_access")
			{
				$merging_permissions = $this->setPermission($data['permissions']['access']);	
				break;
			}
			
			try
			{
				$this_permissions = @unserialize($data['permissions'], true);
				if(!$this_permissions)
					throw new Exception("Erro ao construir permissoes");
				else
					$this_permissions = @$this_permissions['access'];
				
			}catch(Exception $e)
			{
				continue;
			}
			
			$merging_permissions = $this->setPermission($this_permissions,$merging_permissions);
		}
		
		return $merging_permissions;
	}
	
	/**
	 * Vasculha a pasta indicada para ver se tem um modulo valido e as ações dele
	 * @param string $dir_url
	 */
	private function getModulesByDir($dir_url)
	{
		if(!file_exists($dir_url))
			return false;
			
		$modules_data = array();
		
		$dir = scandir($dir_url);
		
		if($dir)
		{
			foreach($dir as $row)
			{
				if($row == ".." || $row == ".")
					continue;
				
				if(is_dir($dir_url . $row))
				{
						$mod_aval = scandir($dir_url . $row);
						
						if($mod_aval)
						{
							foreach($mod_aval as $list)
							{
								if($list == ".." || $list == "." || $list == "Module.php" )
									continue;
									
								$action = str_replace(".php", "", $list);
									
								if(!is_dir($dir_url . $row . "/" . $action)/* && file_exists($dir_url . $row . "/templates/" . $action . ".tpl") */)
								{
									$modules_data['modules'][$row]['actions'][] = $action;
								}
							}
						}
				}
			}
		}
		
			
		return $modules_data;
	}
	
	public function convertToViewAccess($permissions, $rules)
	{
		if(!$permissions || !is_array($permissions))
		 	$permissions = $this->defaultPermission();
		
		if(!$rules || !is_array($rules))
			$rules = $this->defaultRules();
		 	
		 $return = array();	
		 	
		foreach($permissions as $platform => $access)
		{
			if($access['_access'])
			{
				foreach($access['modules'] as $module => $actions)
				{
					foreach($actions['actions'] as $action => $permission)
					{
						$return[$platform][strtolower($module)][strtolower($action)] =($permission)?true:false;
					}
				}
			}
		}
		if(isset($return[the_platform()][the_module()]))
			$return["this_module"] = $return[the_platform()][the_module()];
		
		if(isset($return[the_platform()][the_module()][the_action()]))
			$return["this_module"]['this_action'] = $return[the_platform()][the_module()][the_action()];
		
		if($rules)
		{
			foreach($rules as $key => $value)
			{
				if($value)
					$return['rules'][$key] = true;
			}
		}
		
		return $return;
	}
}