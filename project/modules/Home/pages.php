<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */
 
 $page = SsxPages::getPage();
 
 if(!$page)
 {
 	Ssx::$themes->action_found = false;
 	Ssx::$themes->disable_slug_action();
 	Ssx::$themes->set_404_action();
 }else
 {
 	Ssx::$themes->assign('page', $page);
 }