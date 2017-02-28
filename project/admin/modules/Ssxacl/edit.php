<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.2
 *
 */

$SsxAcl = new SsxAcl();
$SsxGroups = new SsxGroups();

$SsxProtect = new SsxProtect(3600,true,"ssxacl");


$groups = $SsxGroups->getAll($SsxGroups->prefix . '.name','ASC',0,0,array('AND'=>array(array('field'=>$SsxGroups->prefix . '.deleted','compare'=>'=','value'=>'0'))));

Ssx::$themes->assign('groups', $groups);

$group_id = Ssx::$request->fromPost('group_id');
if(!$group_id)
	$group_id = Ssx::$request->fromQuery('group_id');




if(Ssx::$request->isPost() && Ssx::$request->fromPost('save'))
{
	if($SsxProtect->checkToken())
	{
	
		$me = $SsxAcl->getByGroup($group_id);
		$data = Ssx::$request->fromPost('data');
		$data_rules = Ssx::$request->fromPost('rules');
		
		$data_content = array();
		$basic_rules = array();
		
		$basic = $SsxAcl->defaultPermission();
		
		
		if(is_array($data))
		{
			foreach($basic as $local => $model)
			{
				if(isset($data[$local]['_access']) && $data[$local]['_access'])
					$basic[$local]['_access'] = true;
				else
					$basic[$local]['_access'] = false;
				
				foreach($model['modules'] as $module => $actions)
				{
					foreach($actions['actions'] as $action => $value)
					{
						if(isset($data[$local]['modules'][$module]['actions'][$action]) && $data[$local]['modules'][$module]['actions'][$action])
							$basic[$local]['modules'][$module]['actions'][$action] = true;
						else
							$basic[$local]['modules'][$module]['actions'][$action] = false;
					}				
				}
			}
		}
		
		if(is_array($data_rules))
		{
			$basic_rules = $SsxAcl->setRules($data_rules);
		}else{
			$basic_rules = $SsxAcl->defaultRules();
		}
		
		$data_content['access'] = $basic;
		$data_content['rules'] = $basic_rules;
		
		$saveData = array();
		
		if($me)
		{
			if($me['permissions'] != "all_access")
			{
				$saveData = array(
					'id'=>$me['id'],
					'permissions'=>serialize($data_content)
				);
			}
		}else{
			$saveData = array(
				'group_id'=>$group_id,
				'permissions'=>serialize($data_content)
			);
		}
		
		if($saveData)
		{
			$SsxAcl->save($saveData);
			header_redirect(get_url(the_module(), the_action(), array('group_id'=>$group_id,'saved'=>true)));
		}
	}else{
		Ssx::$themes->assign('data_error', 'Erro ao editar permissões, Tempo limite excedido.');
	}
}

if(isset($group_id) && $group_id)
{
		
	$permissions = $SsxAcl->getByGroup($group_id);
	
	if($permissions)
	{
		Ssx::$themes->assign('p_details', $permissions);
		
		$permissions = $permissions['permissions'];
		
		if($permissions != "all_access")
		{
			try
			{
				$permissions = @unserialize($permissions);
				if(!$permissions)
					throw new Exception("dado invalido para deserializar");
			}catch(Exception $e)
			{
				$permissions['access'] = $SsxAcl->defaultPermission();
				$permissions['rules'] = $SsxAcl->defaultRules();
			}
			
			$permissions['access'] = $SsxAcl->setPermission($permissions['access']);
			$permissions['rules'] = $SsxAcl->setRules(@$permissions['rules']);
		}
	}else{
		$permissions['access'] = $SsxAcl->defaultPermission();
		$permissions['rules'] = $SsxAcl->defaultRules();
	}
	
	Ssx::$themes->assign('group_id', $group_id);
	Ssx::$themes->assign('group_permissions', $permissions);
	Ssx::$themes->assign('field_secure', $SsxProtect->getField());
	Ssx::$themes->assign('saved', Ssx::$request->fromQuery('saved'));
}


