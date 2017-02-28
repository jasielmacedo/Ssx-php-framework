<?php
/**
 * 
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * 
 * 
 */
 
 $options = array(
 	1 => 'Aguardando',
 	2 => 'Em andamento',
 	3 => 'Resolvido'	
 );

 $Ticket = new Ticket();
 $TicketReplies = new TicketReplies();
 
 $id = Ssx::$request->fromFriendlyUrl(2);
 
 if(!$id)
 {
 	 header_redirect(get_url(the_module(),"index"));
 }
 
 $view = $Ticket->fill($id,true);
 
 if($view)
 { 	
 	  $replies = $TicketReplies->getByTicket($view['id']);
 	  
 	  Ssx::$themes->assign('view', $view);
 	  Ssx::$themes->assign('replies', $replies);
 	  
 	  
 	  if(Ssx::$request->isPost() && Ssx::$request->fromPost('saveValues'))
 	  {
 	  		$data = array(
 	  			'ticket_id'=>$view['id'],
 	  			'content'=>Ssx::$request->fromPost('ssx_editor')	
 	  		);
 	  		
 	  		$ticket_reply = $TicketReplies->save($data);
 	  		
 	  		header_redirect(get_url(the_module(),the_action()."/".$view['id'],null,true,$ticket_reply));
 	  		exit;
 	  }else
 	  {
 	  		// adiciona um novo reply
	 	  	if(Ssx::$request->fromQuery('addReply'))
	 	  	{
	 	  		$SsxEditor = new SsxEditor();
	 	  		$SsxEditor->editor("",false);
	 	  	
	 	  		Ssx::$themes->assign('reply', true);
	 	  	}
	 	  	
	 	  	// troca o status
	 	  	if(Ssx::$request->fromQuery('changeStatus'))
	 	  	{
	 	  		$status = (int)Ssx::$request->fromQuery('changeStatus');
	 	  		 
	 	  		$Ticket->save(array('id'=>$view['id'],'status'=>$status));
	 	  		 
	 	  		header_redirect(get_url(the_module(),the_action()."/".$view['id'],array('changed'=>true)));
	 	  		exit;
	 	  	}
	 	  	
	 	  	// delete ticket
	 	  	if(Ssx::$request->fromQuery('delete'))
	 	  	{
	 	  		$Ticket->deleteFlag($view['id']);
	 	  		
	 	  		header_redirect(get_url(the_module(),'index'));
	 	  		exit;
	 	  	}
	 	  	
	 	  	// delete reply
	 	  	if(Ssx::$request->fromQuery('deleteReply'))
	 	  	{
	 	  		$reply = Ssx::$request->fromQuery('deleteReply');
	 	  		$TicketReplies->deleteFlag($reply);
	 	  		
	 	  		header_redirect(get_url(the_module(),the_action()."/".$view['id'],array('ticket_reply'=>true)));
	 	  		exit;
	 	  	}
 	  }
 	  
 	  
 	  
 	  Ssx::$themes->assign('options', $options);
 }
 
 Ssx::$themes->assign('ticket_changed', Ssx::$request->fromQuery('changed'));
 Ssx::$themes->assign('ticket_reply', Ssx::$request->fromQuery('ticket_reply'));
 