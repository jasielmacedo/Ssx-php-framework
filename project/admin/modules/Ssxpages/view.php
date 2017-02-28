<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

$SsxPages = new SsxPages();
$SsxTags = new SsxTags();

$id = Ssx::$request->fromFriendlyUrl(2);

if(isset($id) && $id)
{
	$view = $SsxPages->fill($id);
	if($view)
	{
		$tags = $SsxTags->getAllObjectTags($view['id'], $SsxPages->table_name);
		$view['tags'] = $tags;
		
		Ssx::$themes->assign('view', $view);
	}
}else{
	header_redirect(get_url(the_module()));
	exit;
}

$alter_status = Ssx::$request->fromQuery('alter_status');
if($alter_status)
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
	$SsxPages->save($data);
	header_redirect(get_url(the_module(), the_action(), array('id'=>$id)));
}

if(Ssx::$request->fromQuery('delete'))
{
	$SsxPages->delete($id);
	header_redirect(get_url(the_module(),'index'));
}