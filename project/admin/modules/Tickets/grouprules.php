<?php
/**
 * 
 * @author jasiel macedo <jasielmacedo@gmail.com>
 * 
 */


 $SsxGroups = new SsxGroups();
 
 $groups = $SsxGroups->filterData(array('deleted'=>'0'),false);
 
 Ssx::$themes->assign('groups', $groups);
 
 
 if(Ssx::$request->isPost() && Ssx::$request->fromPost('save'))
 {
 	  $keys = Ssx::$request->fromPost('groups'); 
 	  SsxConfig::set(Ticket::TICKET_GROUP_RULES,serialize($keys));
 	  header_redirect(get_url(the_module(),the_action()));
 }
 
 $rules =  SsxConfig::get(Ticket::TICKET_GROUP_RULES,'serialized',true);
 
 Ssx::$themes->assign('gsaved', $rules);