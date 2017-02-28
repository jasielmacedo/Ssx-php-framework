<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class TicketReplies extends SsxModels
{
	
	public $table_name = "ssx_ticket_replies";
	
	public $fields = array(
		'id'=>'int',
		'ticket_id'=>'int',
		'date_created'=>'datetime',
		'created_by'=>'string',
		'date_modified'=>'datetime',
		'deleted'=>'int',
		'modified_by'=>'string',
		'content'=>'string'
	);
	
	public function TicketReplies()
	{
		return parent::super();
	}
	
	public function save($data)
	{
		return parent::saveValues($data,false);
	}
	
	public function getByTicket($ticket,$limit=0,$order="ASC")
	{
		return parent::fetch(array(
				'AND'=>array(
						array('field'=>'ticket_id','compare'=>'=','value'=>$ticket),
						array('field'=>$this->prefix . '.deleted','compare'=>'=','value'=>'0'),
				)
		),'date_created', $order,$limit,0,true);
	}
}