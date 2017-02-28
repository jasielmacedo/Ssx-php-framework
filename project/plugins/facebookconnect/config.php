<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $args = array(
 	'fields'=>array(
 		array('field'=>'active', 'type'=>'check', 'label'=>'Ativo', 'options'=>array('1'=>'&nbsp;')),
 		array('field'=>'app_id', 'type'=>'text', 'label'=>'App id', 'required'=>true, 'error'=>'Informe o APP_ID do app', 'value'=>'APP_ID'),
 		array('field'=>'app_secret', 'type'=>'text', 'label'=>'App Secret', 'required'=>true, 'error'=>'Informe o APP_SECRET do app', 'value'=>'APP_SECRET'),
 		array('field'=>'facebook_url', 'type'=>'text', 'label'=>'Url do Aplicativo'),
 		array('field'=>'require_perm', 'type'=>'check', 'label'=>'Requisitar facebook_id do usuário', 'options'=>array('1'=>'&nbsp;')),
 		array('field'=>'scope', 'type'=>'text', 'label'=>'Permissões necessárias', 'value'=>'user_about_me'),
 	)
 );
 
  $SsxEditConstruct = new SsxEditConstruct($args);
  
  $params = SsxConfig::get('_facebook_connect_params','json');
  if($params && is_array($params))
  {
  	  $SsxEditConstruct->setFieldsValue($params);
  }
  
  if($SsxEditConstruct->save())
  {
  	 $params_acc = $SsxEditConstruct->getDataRequest();
  	 
  	 SsxConfig::set('_facebook_connect_params',json_encode($params_acc),true);
  	 
  	 header_redirect(get_url(the_module(),"facebookconnect", array('saved'=>true)));
  }
  
  if(get_request('saved', 'GET'))
  {
  	  Ssx::$themes->assign('data_error', 'Dados salvos com sucesso');
  }
  
  Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
  Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());
  
  
  