<?php
/**
 * 
 * @author jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 22/01/2015
 * 
 */

$Ticket = new Ticket();
$TicketReplies = new TicketReplies();

if(!SsxAcl::checkPermissionForAction(the_module(),'tipos',the_platform()))
{
	// envia para tickets próprios
	header_redirect(get_url(the_module(),'my',array('notypes'=>Ssx::$request->fromQuery('notypes'))));
}


$page = Ssx::$request->fromQuery('page');
$page = Ssx::$utils->setInt($page);
$page--;
$page = $page<1?0:$page;

$limit = 20;

$args = array(
	'JOIN'=>array(
		'type'=>'inner',
		'conditions'=>array(
			array(
				'prefix'=>'TT',
				'table'=>'ssx_ticket_type',
				'field'=>array(
					'id'=>array($Ticket->prefix=>'ticket_type')
				)
			)
		)
	),
	'fields'=>array(
			$Ticket->prefix=>$Ticket->field_array(),
			'TT'=>array('object_name As `type`')
	),
	'AND'=>array(
			array('field'=>$Ticket->prefix.'.deleted', 'compare'=>'=', 'value'=>0)
	)
);
$all = $Ticket->getAll("status ASC, priority DESC, ".$Ticket->prefix.".date_created","DESC", $limit, $page, $args,true);
if($all)
{
	foreach($all as $key => $tk)
	{
		$last_reply = $TicketReplies->getByTicket($tk['id'],1,"DESC");
		if($last_reply)
		{
			$all[$key]['last_reply'] = array(
				'by'=>$last_reply[0]['created_by_name'],
				'date'=>$last_reply[0]['date_created']
			);
		}
	}
}

$pagination = $Ticket->mountPagination($args, $limit);

Ssx::$themes->assign('all', $all);
Ssx::$themes->assign('pagination', $pagination);
Ssx::$themes->assign('pagination_page', $page+1);
Ssx::$themes->assign('notypes', Ssx::$request->fromQuery('notypes'));