<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.2
 *
 */

  $args = array(
  	'fields'=>array(
  		array('field'=>'file_zip', 'label'=>'Selecione o arquivo compactado do plugin', 'type'=>'file')
  	)
  );
 

   $SsxEditConstruct = new SsxEditConstruct($args);
   
   if(Ssx::$request->fromQuery('recover'))
   {
   	   $data = Ssx::$plugins->recoverPlugins();
   	   header_redirect(get_url(the_module(),the_action(),array('recover_success'=>($data>0)?'true':'false')));
   }
   
    $recover_success = Ssx::$request->fromQuery('recover_success');
   
    if($recover_success)
    {
    	Ssx::$themes->assign('recover', $recover_success);
    }
   
   
   if($SsxEditConstruct->save())
   {
   		$data = $SsxEditConstruct->getDataRequest();
   	
   	    $install = Ssx::$plugins->install($data['file_zip']);
   	    if($install !== true)
   	    {
   	    	Ssx::$themes->assign('data_error', $install);
   	    }else{
   	    	Ssx::$themes->assign('data_error', 'Plugin instalado com sucesso');
   	    }
   }
  
   Ssx::$themes->assign('ssx_fields', $SsxEditConstruct->constructTable());
   Ssx::$themes->assign('ssx_fields_js_content', $SsxEditConstruct->constructValidator());