<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.2
 *
 */


 
 
 $page = Ssx::$request->fromQuery('page');
 $page = Ssx::$utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $plugin_id = Ssx::$request->fromQuery('plugin_id');
 
 if(Ssx::$request->isQuery())
 {
	 if(Ssx::$request->fromQuery('desactive'))
	 {
		
	 	Ssx::$plugins->desactive($plugin_id);
		
		header_redirect(get_url(the_module(),the_action()));
	 }
	 
	 if(Ssx::$request->fromQuery('active'))
	 {
	
	 	$status = Ssx::$plugins->reactive($plugin_id);
	 	if($status === true)
	 	{
	 		header_redirect(get_url(the_module(),the_action()));
	 	}else{
	 		Ssx::$themes->assign('data_error', $status);
	 	}
	 }
	 
	 if(Ssx::$request->fromQuery('delete'))
	 {
	 	Ssx::$plugins->definityDelete($plugin_id);
	 	
	 	header_redirect(get_url(the_module(),the_action()));
	 }
 }
 

 $all = Ssx::$plugins->getAll("date_created","DESC", $limit, $page);
 
 if($all)
 {
 	foreach($all as $k => $plugin)
 	{
 		if(file_exists(PLUGINPATH . $plugin['reference_name'] . "/config.php") && file_exists(PLUGINPATH . $plugin['reference_name'] . "/config.tpl"))
			$all[$k]['has_config'] = true;
 	}
 }
 
 $pagination = Ssx::$plugins->mountPagination(null, $limit);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 Ssx::$themes->assign('user_deleted', get_request('user_deleted', 'GET'));