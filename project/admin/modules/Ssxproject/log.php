<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

 $SsxSessionLog = new SsxSessionLog();
 
 Ssx::$themes->ssx_module_locale->plural = "Logs do Sistema";
 Ssx::$themes->ssx_module_locale->singular = "Log";
 
 
 $page = Ssx::$request->fromQuery('page');
 $page = Ssx::$utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $args = null;
 $all = $SsxSessionLog->getAll("date_created","DESC", $limit, $page, $args,true);
 $pagination = $SsxSessionLog->mountPagination($args, $limit);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 