<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */


$SsxGroups = new SsxGroups();
$SsxUserGroups = new SsxUserGroups();

$id = Ssx::$request->fromFriendlyUrl(2);

load_js('admin.ssxgroups.view.js');


if(isset($id) && $id)
{
	$SsxGroups->addFilterListener('ssx_filterdata','ssx_get_table_logs');
	$view = $SsxGroups->fill($id);
	
	if(!$view)
		header_redirect(get_url(the_module(), 'index'));
		
	$users = $SsxUserGroups->getUserByGroup($view['id']);

	
	Ssx::$themes->assign('view',$view );
	Ssx::$themes->assign('users', $users);
}else{
	header_redirect(get_url(the_module(),'index'));
	exit;
}


$group_alter_status = Ssx::$request->fromQuery('group_alter_status');
if($group_alter_status && $id != "1")
{
	$data = array(
		'id'=>$id
	);
	if($view['status'] == "1")
	{
		$data['status'] = "0";
	}else{
		$data['status'] = "1";
	}
	$SsxGroups->save($data);
	header_redirect(get_url(the_module(), the_action()."/".$id));
}

if(Ssx::$request->fromQuery('delete') && $id != "1")
{
	$SsxGroups->deleteFlag($id);
	header_redirect(get_url(the_module(),'index'));
}
