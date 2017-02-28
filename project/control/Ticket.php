<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

class Ticket extends SsxModels
{
	const TICKET_GROUP_RULES = "ticket_group_rules";
	
	public $table_name = "ssx_ticket";
	
	public $prefix = "TK";
	
	public $fields = array(
		'id'=>'int',
		'project_id'=>'int',
		'date_created'=>'datetime',
		'created_by'=>'string',
		'date_modified'=>'datetime',
		'modified_by'=>'string',
		'deleted'=>'int',
		'ticket_type'=>'int',
		'title'=>'string',
		'priority'=>'int',
		'status'=>'int'
	);
	
	public function Ticket()
	{
		return parent::super();
	}
	
	public function save($data)
	{
		if(!isset($data['id']) || !$data['id'])
			$adding = true;
		
		$ticket = parent::saveValues($data,false);
		
		if($ticket && $adding && isset($data['content']) && $data['content'])
		{
			$data_reply = array(
				'content'=>$data['content'],
				'ticket_id'=>$ticket
			);
			
			$TicketReplies = new TicketReplies();
			$TicketReplies->save($data_reply);
		}		
		return $ticket;
	}
}