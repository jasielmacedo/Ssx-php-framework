<?php
/**
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

defined("SSX") or die;

class SsxUsers extends SsxModels
{
	public $link;
	
	public $table_name = "ssx_user";
	
	public $prefix = "SU";
	
	public $fields = array(
		'id'=>'string',
		'project_id'=>'int',
	    'created_by'=>'string',
	    'date_created'=>'datetime',
	    'modified_by'=>'string',
	 	'date_modified'=>'datetime',
	    'deleted'=>'int',
	    'name'=>'string',
		'user'=>'string',
	    'email'=>'string',
		'doc'=>'string',
	    'status'=>'int'
	);	
	
	private static $session_name = "__ssx_user_session";
	
	private static $user_permissions;
	private static $user_rules;
	
	public function __construct()
	{		
		parent::super();
	}
	
	public function save($data)
	{
		$id = parent::saveValues($data, true);
		
		$SsxUserGroups = new SsxUserGroups();
		
		// verifica se o usuário já está em algum grupo
		$in_group = $SsxUserGroups->getGroupByUser($id);
		
		if(!$in_group && (!isset($data['group_id']) || !$data['group_id']))
		{
			// traz o grupo default caso ele tenha sido indicado
			$group_default = SsxConfig::get(SsxConfig::SSX_DEFAULT_USER_GROUP);
			
			if($group_default)
			{
				$data['group_id'] = $group_default;
			}
		}
		
		/* relações com o grupo */
		if(isset($data['group_id']) && $data['group_id'])
		{
			$relation = $SsxUserGroups->getRelations($id, $data['group_id']);
			if(!$relation)
			{
				if($in_group)
				{
					$SsxUserGroups->removeRelationByUser($id);
				}
				
				$SsxUserGroups->save(array('group_id'=>$data['group_id'],'user_id'=>$id));
			}
		}
		
		if(isset($data['password']))
		{
			$dataPass = array(
				'user_id'=>	$id,
				'password'=>$data['password'],
				'type'=>isset($data['password_type']) && $data['password_type']?$data['password_type']:"1",
			);
			
			$SsxUserPd = new SsxUsersPd();
			$SsxUserPd->save($dataPass);
		}
		
		SsxActivity::dispatchActivity(SsxActivity::SSX_SAVE_USER,$id);
		return $id;
	}
	
	/**
	 * Altera o grupo atual do usuário, eliminando a 
	 * relação atual caso tenha alguma conexão
	 * 
	 * @param string $id
	 * @param string $new_group_id
	 * @return boolean
	 */
	public function changeGroup($id, $new_group_id)
	{
		if(isset($new_group_id) && $new_group_id)
		{
			$SsxUserGroups = new SsxUserGroups();
			
			$in_group = $SsxUserGroups->getGroupByUser($id);
			$relation = $SsxUserGroups->getRelations($id, $new_group_id);
			
			if(!$relation)
			{
				if($in_group)
				{
					$SsxUserGroups->removeRelationByUser($id);
				}
		
				return $SsxUserGroups->save(array('group_id'=>$new_group_id,'user_id'=>$id));
			}
		}
		return false;
	}
	
	/**
	 * Autenticação de usuário
	 * Criação de sessão
	 * 
	 * @param user|email $user
	 * @param string $pass
	 * @param boolean $cookie_verification
	 * @param boolean $guest
	 * 
	 * @return boolean
	 */
	public function auth($user, $pass, $cookie_verification=true,$guest=false)
	{		
		if($guest)
			$user = "guest";
		
		$dataLogin = array(
			'status'=>1,
			'project_id'=>Ssx::$project,
			'deleted'=>"0"								   
		);
		
		if(Ssx::$utils->check_email($user))
		{
			$dataLogin['email'] = $user;
		}else{
			$dataLogin['user'] = $user;
		}
		
		$authData = parent::filterData($dataLogin,true);
	
		if($authData)
		{
			$SsxUsersPd = new SsxUsersPd();
			
			if($SsxUsersPd->checkPassword($authData['id'], $pass) || $guest)
			{
				$SsxUserGroups = new SsxUserGroups();
				
				$groups = $SsxUserGroups->getGroupByUser($authData['id']);
				
				if(isset($groups) && $groups)
				{
					$session_data = array
					(
						'hash'=>md5(constant('PROJECTPATH')),
						'user_id'=>$authData['id'],
						'group_id'=>$groups['id'],
					);
					
					SsxSession::regenerateSessionId();
					
					SsxAuthSession::openSession($session_data,true, self::$session_name,$cookie_verification);
					
					//SsxSession::regenerateSessionId();
					
					SsxActivity::dispatchActivity(SsxActivity::SSX_USER_AUTH);
					
					// gera novas permissões
					$SsxAcl = new SsxAcl();
					
					$permissions = $SsxAcl->getPermissionByGroup($session_data['group_id']);
					
					SsxUsers::setPermission($permissions);
					
					if(!SsxAcl::checkPermissionForLocal(the_platform()))
					{			
						self::logout(false);
						Ssx::$session_log->addLog(the_platform() . "-- login success + failed - logando em uma area nao permitida - user -- ". $user);
						return false;
					}
					
					// registro de sucesso no login
					if(!$guest)
						Ssx::$session_log->addLog(the_platform() . "-- login success - user -- ". $user);
					
					return true;
				}
			}			
		}
		// registro de falha de login
		Ssx::$session_log->addLog(the_platform() . "-- login failed - user -- ". $user);
		
		return false;
	}
	
	public function delete($id)
	{
		return parent::definityDelete($id);
	}
	
	public static function login($user,$pass)
	{
		$SsxUsers = new SsxUsers;
		return $SsxUsers->auth($user,$pass);
	}
	
	public function activeStatus($id){ $this->save(array('id'=>$id, 'status'=>'1')); }
	public function desactiveStatus($id){ $this->save(array('id'=>$id, 'status'=>'0')); }
	
	public function getByEmail($email){ return parent::filterData(array('email'=>$email, 'deleted'=>'0','project_id'=>Ssx::$project),true); }
	public function getByUser($user)  { return parent::filterData(array('user'=>$user, 'deleted'=>'0','project_id'=>Ssx::$project),true);   }
	public function getByDoc($doc){  return parent::filterData(array('doc'=>$doc, 'deleted'=>'0','project_id'=>Ssx::$project),true);  }
	
	public static function getDataSession()
	{
		return SsxAuthSession::getSession(self::$session_name);
	}
	
	public static $userLogged = false;
	/**
	 * Retorna o id do usuário que está logado
	 * @var guest Caso seja indicada, ele retornará false caso o usuário logado seja um visitante
	 * @return string|boolean
	 */
	public static function getUser($guest=false)
	{
		$session = self::getDataSession();
		
		if(!$session)
			return false;
			
		if(!isset($session['hash']) || $session['hash'] != md5(constant('PROJECTPATH')))
			return false;
		
		if(SsxUsers::$userLogged)
		{
			if(!$guest && SsxUsers::$userLogged == Ssx::$project_data->g_id)
				return false;
			else
				return SsxUsers::$userLogged;
		}
			
		if(isset($session['user_id']) && $session['user_id'])
		{
			$SsxUserGroups = new SsxUserGroups();
			$gp = $SsxUserGroups->getGroupByUser($session['user_id']);
			
			if($gp)
			{
				if(!$guest && $gp['level'] == SsxGroups::LEVEL_GUEST)
				{
					SsxUsers::$userLogged = Ssx::$project_data->g_id;
					return false;
				}else 
				{
					if($gp['level'] == SsxGroups::LEVEL_GUEST)
						SsxUsers::$userLogged = Ssx::$project_data->g_id;
					else
						SsxUsers::$userLogged = $session['user_id'];
					return $session['user_id'];
				}
			}
		}
		return false;
	}
	
	public static function getUserGroupLevel($id)
	{
		$SsxUserGroups = new SsxUserGroups();
		$gp = $SsxUserGroups->getGroupByUser($id);
		return $gp['level'];
	}
	
	public static function getSessionName()
	{
		return self::$session_name;
	}
	
	public static function getPermission(){ return self::$user_permissions; }
	public static function getRules(){ return self::$user_rules; }
	
	public static function setPermission($permission){self::$user_permissions = $permission['access']; self::$user_rules = $permission['rules']; }
	
	/**
	 * Função removida
	 */
	public static function restrict()
	{
		// função removida
	}
	
	public static function recoverPass($email, $url_callback="", $sendfrom="", $sendfrom_name="", $subject="")
	{
		if(!$url_callback)
			$url_callback = projecturl() . ADMIN_FOLDER . "/auth/login";
		
		$SsxUsers = new SsxUsers();
		$SsxUserToken = new SsxUserToken();
		
		$auth = $SsxUsers->getByEmail($email);
		if(!$auth)
			return false;
			
		$token = $SsxUserToken->generateToken($auth['id']);
		
		$urlRequest = array(
			'm'=>$auth['id'],
			'l'=>true,
			't'=>$token
		);
		
		$query = http_build_query($urlRequest);
		
		$callback = $url_callback . "?" . $query;
		
		$SsxMail = new SsxMail();
		$SsxMail->mail->CharSet   = "UTF-8"; 
		
		$body = "
			<h2>Recuperação de senha:</h2>
			
			Você solicitou alteração de senha<br /><br />
			
			Acesse ".$callback." para alterar sua senha <br /><br />
			
			".siteurl()."
		";
		
		$from = array('email'	=>	'no-reply@'.domain_name(false), 'name' =>	'Update');
		if($sendfrom)
		{
			$from['email'] = $sendfrom;
		}
		
		if($sendfrom_name)
		{
			$from['name'] = $sendfrom_name;
		}
		
		if(!$subject)
			$subject = 'Recuperação de Senha - '.domain_name();
		
		
		$send = $SsxMail->SimpleSend(array(
			  		'from'		=>	$from,
					'addresses' =>  array(
							array('email'	=> $email, 'name'	=>	''),
							),
			  		'subject'	=>	$subject,
			  		'body'		=>	$body,
			  ));
		
		Ssx::$session_log->addLog(the_platform() . "-- recuperacao de email solicitada - email: ". $email);
			  
		return $send;
	}
	
	public static function logout($redirect=true, $redirect_url="")
	{
		if(!$redirect_url)
			$redirect_url = get_url('auth', 'login');
		
		Ssx::$session_log->addLog(the_platform() . "-- logout success");
		
		SsxUsers::$userLogged = false;
		
		SsxAuthSession::dropSession(self::$session_name);
		
		if($redirect)
			header_redirect($redirect_url);

	}
}