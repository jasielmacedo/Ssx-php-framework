<?php
/**
 * 
 * @author jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */
  
  $SsxUsers = new SsxUsers();
  $SsxUserToken = new SsxUserToken();
  $SsxProtect = new SsxProtect(900,true);
  
  define("DISPLAY_ALONE", true);
  
  Ssx::$themes->set_theme_title('| Login', false);
  
 // Ssx::$plugins->load('Plugin_Menu')->disableMenu(); 
   
  $redirect = Ssx::$request->fromPost('redirect');
  if(!$redirect)
  	$redirect = Ssx::$request->fromQuery('redirect');
  
  Ssx::$themes->assign('redirect', $redirect);  
  $slug = Ssx::$request->fromFriendlyUrl(1);
  
 
  
  if($slug == "logout")
  {
  	 SsxUsers::logout();
  }
  
  if(Ssx::$request->fromQuery('alter'))
  {
  	  Ssx::$themes->assign('user_error', 'Senha alterada com sucesso.');
  }else if(Ssx::$request->fromQuery('esend'))
  {
  	  Ssx::$themes->assign('recover', 'Alteração de senha enviada. Verifique seu email para continuar');
  }
  
  /**
   *  Requisição de nova senha
   */
  if(Ssx::$request->fromQuery('l'))
  {  
  	if($SsxProtect->checkToken())
  	{
	  	$user_id = Ssx::$request->fromQuery('m');
	  	$token = Ssx::$request->fromQuery('t');
	  	
	  	$auth = $SsxUserToken->filterData(array('token'=>$token, 'user_id'=>$user_id, 'used'=>'0'), true);
	  	if($auth)
	  	{  		
	  		$date_request = new DateTime($auth['date_created']);
	  		$now_request = new DateTime(date("Y-m-d H:i:s"));
	  		
	  		$diff = $date_request->diff($now_request);
	  		
	  		if($diff->d == 0 && $diff->h < 2)
	  		{
	  			// altera a senha conforme solicitado
	  			if(Ssx::$request->fromPost('change_pass'))
	  			{
	  				$new_pass = Ssx::$request->fromPost('new_pass');	
	  				
	  				$data_alter = array(
	  					'id'=>$user_id,
	  					'modified_by'=>$user_id,
	  					'password'=>$new_pass,
	  				);
	  				
	  				$SsxUsers->save($data_alter);
	  				
	  				$data_token = array(
	  					'id'=>$auth['id'],
	  					'used'=>'1'
	  				);
	  				
	  				$SsxUserToken->save($data_token);
	  				
	  				header_redirect(get_url(the_module(),the_action(), array('alter'=>true)));
	  			}
	  			
	  			Ssx::$themes->assign('password_request', true);
	  			Ssx::$themes->assign('password_token', $auth['token']);
	  			Ssx::$themes->assign('password_user', $auth['user_id']);
	  		}else{
	  			Ssx::$themes->assign('user_error', 'Requisição de alteração de senha já expirou.');
	  		}
	  	}else{
	  		Ssx::$themes->assign('user_error', 'Requisição de alteração de senha inválida.');
	  	}
  	}else{
  		Ssx::$themes->assign('user_error', 'Não foi possível completar a sua solicitação. Tente novamente');
  	}
  }
  
  /**
   * Login
   */
  if(Ssx::$request->fromPost('login'))
  {
  	
  	  if($SsxProtect->checkToken())
  	  {
  	  	  $user = Ssx::$request->fromPost('user');
  	  	  $pass  = Ssx::$request->fromPost('pass');
  	  	  
  	  	  if(!$user || !$pass)
  	  	  {
  	  	  	 Ssx::$themes->assign('user_error', 'Informe os dados corretamente.');
  	  	  }else if(!$SsxUsers->auth($user, $pass))
	  	  {
	  	  	 Ssx::$themes->assign('user_error', 'Usu&aacute;rio ou senha inv&aacute;lidos');
	  	  }else{	
	  	  	if($redirect)
	  	  	{
	  	  		header_redirect(urldecode($redirect));
	  	  	}else{
	  	  		header_redirect(get_url('Home', 'index'));
	  	  	}
	  	  }
  	  }else{
  	  	  Ssx::$themes->assign('user_error', 'Não foi possível completar a sua solicitação. Tente novamente');
  	  }
  }
  
  /**
   * Envia email de alteração de senha
   */
  if(Ssx::$request->fromPost('forgot'))
  {
  	  if($SsxProtect->checkToken())
  	  {
	  	  $email = Ssx::$request->fromPost('forgot_email');
	  	  
	  	  $recover = SsxUsers::recoverPass($email);
	  	  if(!$recover)
	  	  {
	  	  		Ssx::$themes->assign('user_error', 'Email inválido.');
	  	  }else{
	  	  	    header_redirect(get_url(the_module(), the_action(), array('esend'=>true)));
	  	  }
  	  }else
  	  {
  	  	  Ssx::$themes->assign('user_error', 'Não foi possível completar a sua solicitação. Tente novamente');
  	  }
  }
  
  
  /**
   * Gerado no final porque todos os hacks são refeitos
   * */
  $field_hash = $SsxProtect->getField();
  Ssx::$themes->assign('field_token',$field_hash);
  
  