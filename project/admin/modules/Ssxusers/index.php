<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $SsxUsers = new SsxUsers();
 $SsxGroups = new SsxGroups();
  
 $page = (int)Ssx::$request->fromQuery('page');
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20; 
 $args = array('AND'=>array(array('field'=>$SsxUsers->prefix.".deleted",'compare'=>"=",'value'=>"0")));
 
 $group_selected = false;
 
 $s = Ssx::$request->fromQuery('s');
 
 if(Ssx::$request->isQuery())
 {
 	$group = Ssx::$request->fromQuery('user_group');
 	if($group)
 	{
	 	$args['JOIN'] = array(
	 			'type'=>'inner',
	 			'conditions'=>array(
	 					array(
	 							'prefix'=>'UG',
	 							'table'=>'ssx_user_groups',
	 							'field'=>array(
	 									'user_id'=>array('SU'=>'id')
	 							)
	 					),
	 					array(
								'prefix'=>'GR',
								'table'=>'ssx_groups',
								'field'=>array(
									'id'=>array('UG'=>'group_id'),
									'deleted'=>'0'
								)
						)
	 			)
	 	);	 	
	 	$args['fields'] = array($SsxUsers->prefix =>$SsxUsers->field_array()); 	
	 	$args['AND'][] = array('field'=>$SsxGroups->prefix.".id",'compare'=>"=",'value'=>$group);
	 	
	 	$group_selected = $group;
 	}
 	
 	
 	if($s)
 	{
 		$args['AND'][] = array('field'=>$SsxUsers->prefix.".name",'compare'=>"LIKE",'value'=>"%".$s."%");
 	}
 }
 

  
 $all = $SsxUsers->getAll("date_created","DESC", $limit, $page, $args, true);

 $pagination = $SsxUsers->mountPagination($args, $limit);
 $pagination = $SsxUsers->pg2pg($pagination,6, $page);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 Ssx::$themes->assign('user_deleted', Ssx::$request->fromQuery('user_deleted'));
 Ssx::$themes->assign('search_query', $s);
 Ssx::$themes->assign('groups', $SsxGroups->toOptions(array('AND'=>array(array('field'=>$SsxGroups->prefix.'.level','compare'=>'!=','value'=>SsxGroups::LEVEL_GUEST))),true));
 Ssx::$themes->assign('group_selected',$group_selected);
 
 