<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */


/*locale*/
$locale = new SsxModulesLocale();
$locale->plural = "Autenticação";
$locale->singular = "Trocar senha";
Ssx::$themes->setModuleLocale($locale);

$SsxUsers = new SsxUsers();
$SsxProtect = new SsxProtect(600,true);
 
Ssx::$themes->set_theme_title('| Trocar senha', false);
 
$user_id = Ssx::$request->fromQuery('id');

if(Ssx::$request->fromQuery('success'))
{
	Ssx::$themes->assign('success', "Senha alterada com sucesso.");
}

$user_data = SsxUsers::getUser();
$userLogged = $SsxUsers->fill($user_data);
 
$userFill = $userLogged;
$super_admin = false;

 if(isset($user_id) && $user_id)
 {
 	if($user_id != $user_data && SsxAcl::checkPermissionForAction("Ssxusers","edit",the_platform()))
 	{
 		$userFill = $SsxUsers->fill($user_id);
 		Ssx::$themes->assign('user_is_other',true);
 		Ssx::$themes->assign('userChange',$userFill);
 		$super_admin = true;
 	}else{
 		Ssx::$themes->assign('pass_error', 'Você não tem permissão para alterar senha de outros usuários.');
 	}
 }
 
 Ssx::$themes->assign('user', $userLogged); 
 
 if(Ssx::$request->isPost() && Ssx::$request->fromPost('saveChange') && $userFill)
 {
 	  if($SsxProtect->checkToken())
  	  {
  	  	  $SsxUsersPd = new SsxUsersPd();
	 	  $new_pass = Ssx::$request->fromPost('new_pass');
	 	  
	 	  $data = array(
	 	  	 'id'=>$userFill['id'],
	 	  	 'password'=>$new_pass
	 	  );

	 	  if(!$super_admin && !$SsxUsersPd->checkPassword($userFill['id'],Ssx::$request->fromPost('old_pass')))
	 	  {
	 	  	 Ssx::$themes->assign('pass_error', 'Senha atual informada é inválida');
	 	  }else
	 	  {
	 	  	 $SsxUsers->save($data);
	 	  	 
	 	  	 if($super_admin)
	 	  	 {
	 	  	 	Ssx::$session_log->addLog(the_platform() . ": troca de senha do usuário (".$userFill['id'].") realizada por (".$userLogged['id'].")" );
	 	  	 	header_redirect(get_url(the_module(),the_action(),array('success'=>true,'id'=>$userFill['id'])));
	 	  	 }
	 	  	 else
	 	  	 {
	 	  	 	Ssx::$session_log->addLog(the_platform() . ": troca de senha realizada pelo usuário" );
	 	  	 	header_redirect(get_url(the_module(),the_action(),array('success'=>true)));
	 	  	 }	 	  		 
	 	  }
  	  }else
  	  {
  	  	  Ssx::$themes->assign('pass_error', 'Não foi possível completar a sua solicitação. Tente Novamente.');		
  	  }
 }
 
 $field_hash = $SsxProtect->getField();
 Ssx::$themes->assign('field_token',$field_hash);