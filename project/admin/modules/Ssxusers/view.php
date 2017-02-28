<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

load_js('admin.ssxusers.view.js');

$SsxUsers = new SsxUsers();

$id = Ssx::$request->fromFriendlyUrl(2);
$user_logged = $SsxUsers->getDataSession();

if(isset($id) && $id)
{
	$SsxUsers->addFilterListener('ssx_fill','ssx_get_table_logs');
	$view = $SsxUsers->fill($id, true);
	
	
	if(!$view)
		header_redirect(get_url(the_module(), 'index'));
		
	$addicional_content = SsxActivity::dispatchActivity('ssx_users_view_fields', $view);	
		
	Ssx::$themes->assign('view',$view );
	
	if(is_string($addicional_content))
		Ssx::$themes->assign('addicional_content',$addicional_content);
	
	if($user_logged['user_id'] == $id)
		Ssx::$themes->assign('is_your', true);
	else
		Ssx::$themes->assign('is_your', false);
}

if(Ssx::$request->fromQuery('user_alter_status'))
{
	if($user_logged['user_id'] == $id)
	{
		Ssx::$themes->assign('view_error', "Voc&ecirc; n&atilde;o pode se desativar.");
	}elseif($id == "1")
	{
		Ssx::$themes->assign('view_error', "Voc&ecirc; n&atilde;o pode desativar o super admin");
	}else{
		if($view['status'] == "1")
		{
			$SsxUsers->desactiveStatus($id);
		}else{
			$SsxUsers->activeStatus($id);
		}
		
		header_redirect(get_url(the_module(), 'view/'.$id));
	}	
}

if(Ssx::$request->fromQuery('user_delete'))
{
	if($user_logged['user_id'] == $id)
	{
		Ssx::$themes->assign('view_error', "Voc&ecirc; n&atilde;o pode se deletar.");
	}elseif($id == "1")
	{
		Ssx::$themes->assign('view_error', "Voc&ecirc; n&atilde;o pode deletar o super admin");
	}else{
		$SsxUsers->deleteFlag($id);
				
		header_redirect(get_url(the_module(), 'index', array('user_deleted'=>true)));
	}	
}