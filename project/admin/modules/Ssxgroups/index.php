<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $SsxGroups = new SsxGroups();
 
 $page = Ssx::$request->fromQuery('page');
 $page = Ssx::$utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $args = array('AND'=>array(array('field'=>$SsxGroups->prefix.'.deleted', 'compare'=>'=', 'value'=>0)));
 $all = $SsxGroups->getAll("date_created","DESC", $limit, $page, $args,true);
 $pagination = $SsxGroups->mountPagination($args, $limit);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 Ssx::$themes->assign('group_deleted', Ssx::$request->fromQuery('group_deleted'));