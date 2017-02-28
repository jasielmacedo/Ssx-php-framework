<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */ 


 $SsxGroups = new SsxGroups();
 
 $args = array(
 	'fields'=>array(
	 	array('field'=>'name','label'=>'Nome:', 'type'=>'text', 'required'=>true, 'error'=>'informe o nome do grupo', 'length'=>'4'),
	 	array('field'=>'level','label'=>'Nivel do grupo:', 'type'=>'select', 'required'=>true, 'options'=>array('0'=>'admin','1'=>'usuário', '2'=>'visitante'),'error'=>'informe o nível do grupo'),
	 	array('field'=>'description','label'=>'Descrição:','type'=>'textarea'),
	    array('field'=>'id', 'type'=>'hidden'),
	)
 );
 
 $SsxEditConstruct = new SsxEditConstruct($args);
 
 $id = Ssx::$request->fromFriendlyUrl(2);
 
 if(isset($id) && $id)
 {
 	$fill = $SsxGroups->fill($id);
 	if($fill)
 	{
 		$SsxEditConstruct->setFieldsValue($fill);
 	}else{
 		$id = false;
 	}
 }
 
 
 
 if(Ssx::$request->fromPost('saveValues'))
 {
 	 $data = $SsxEditConstruct->getDataRequest();
 	 
 	 if($SsxGroups->check_name($data['name']) && !$id)
 	 {
 	 	Ssx::$themes->assign('data_error', 'J&aacute; existe um grupo com esse nome');
 	 }else
 	 {
 	 	$id = $SsxGroups->save($data);
 	 	header_redirect(get_url(the_module(), 'view/'.$id));
 	 }
 }
 
 if(isset($user_data) && $user_data)
 {
 	$SsxEditConstruct->setFieldsValue($user_data);
 }
 
  
 Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
 Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());