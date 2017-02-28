<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $SsxPages = new SsxPages();
 
 $page = Ssx::$request->fromQuery('page');
 $page = Ssx::$utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $args = null;
 
 $s = Ssx::$request->fromQuery('s');
 
 if($s)
 {
 	$args = array(
 		'AND'=>array(
 			array(
 				'field'=>$SsxPages->prefix.".title",
	 			'compare'=>"LIKE",
	 			'value'=>"%".$s."%"
 			)
 		)
 	);
 }

 $all = $SsxPages->getAll("date_created","DESC", $limit, $page, $args, true);
 $pagination = $SsxPages->mountPagination($args, $limit);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 Ssx::$themes->assign('search_query', $s);

 