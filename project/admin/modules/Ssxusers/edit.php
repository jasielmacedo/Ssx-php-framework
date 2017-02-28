<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.2
 *
 */
 

 $id =  Ssx::$request->fromFriendlyUrl(2);

 $SsxUsers = new SsxUsers();
 $SsxGroups = new SsxGroups();
 $SsxUserGroups = new SsxUserGroups();
 
 
 $groups_select = $SsxGroups->toOptions(array('AND'=>array(array('field'=>$SsxGroups->prefix.'.level', 'compare'=>'!=', 'value'=>'2'),array('field'=>$SsxGroups->prefix.'.deleted', 'compare'=>'=', 'value'=>'0'))),true);
 
 
 $args = array(
 	'fields'=>array(
 		array('field'=>'group_id','label'=>'Grupo','type'=>'select', 'required'=>true,'options'=>$groups_select, 'error'=>'informe o usu&aacute;rio'),
	 	array('field'=>'name','label'=>'Nome', 'type'=>'text', 'required'=>true, 'error'=>'informe o nome do usu&aacute;rio', 'length'=>'4'),
	 	array('field'=>'email','label'=>'Email','type'=>'email', 'required'=>true, 'error'=>'informe o email do usu&aacute;rio', 'model'=>'email'),
	 	array('field'=>'user','label'=>'Usu&aacute;rio','type'=>'text', 'required'=>true, 'error'=>'informe o usu&aacute;rio','length'=>'5'),
 		array('field'=>'doc','label'=>'Documento de Id','type'=>'text', 'required'=>false, 'error'=>'informe o documento usu&aacute;rio'),
	 	array('field'=>'password', 'label'=>'Senha', 'type'=>'password', 'required'=>true, 'error'=>'informe a senha', 'length'=>'6'),
	 	array('field'=>'password_confirm','label'=>'Confirmar senha', 'type'=>'password', 'required'=>true, 'compare'=>'password',  'error'=>'confirme a senha'),
	 	array('field'=>'id', 'type'=>'hidden'),
	)
 );
 
 $args = SsxActivity::dispatchActivity('ssx_users_edit_args', $args);
 
 $SsxEditConstruct = new SsxEditConstruct($args,true);
  
 if(isset($id) && $id)
 {
 	$fill = $SsxUsers->fill($id);
 	if($fill)
 	{
 		$group_saved = $SsxUserGroups->getGroupByUser($fill['id']);
 		if($group_saved)
 		{
 			$SsxEditConstruct->setFieldsValue(array('group_id'=>$group_saved['id']));
 		}
 		$SsxEditConstruct->setFieldsValue($fill);
 		$SsxEditConstruct->ocultFields(array('password','password_confirm'));
 	}else{
 		$id = false;
 	}
 }
 
 
 if($SsxEditConstruct->save())
 {
 	 $data = $SsxEditConstruct->getDataRequest();
 	 
 	 if($data)
 	 { 	 
	 	 if($SsxUsers->getByEmail($data['email']) && !$id)
	 	 {
	 	 	Ssx::$themes->assign('data_error', 'Email já cadastrado');
	 	 }elseif($SsxUsers->getByUser($data['user']) && !$id)
	 	 {
	 	 	Ssx::$themes->assign('data_error', 'Usuário já cadastrado');
	 	 }else
	 	 {
	 	 	
	 	 	 $id = $SsxUsers->save($data);
	 	 		
	 	 	 SsxActivity::dispatchActivity('ssx_users_edit_save', $id);
	 	 	
	 	 	 header_redirect(get_url(the_module(), 'view/'.$id));
	 	 }
 	 }else{
 	 	 Ssx::$themes->assign('data_error', 'Não foi possível completar a sua solicitação. Tente novamente.');
 	 }
 }
 
 if(isset($user_data) && $user_data)
 {
 	$SsxEditConstruct->setFieldsValue($user_data);
 }
 
  
 Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
 Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());