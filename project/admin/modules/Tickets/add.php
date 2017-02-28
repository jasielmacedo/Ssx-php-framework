<?php
/**
 *
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 *
 */

load_js('admin.ssxpages.edit.js');
load_js('SsxUpload');
load_js('jquery.form');
load_js('tag-it.min');
load_js("https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js");

$SsxEditor = new SsxEditor();
$SsxProtect = new SsxProtect(3600,true,"admin_add_ticket");

$TicketType = new TicketType();
$Ticket = new Ticket();
$SsxUserGroups = new SsxUserGroups();

$options = $TicketType->toOptions();

if(!$options)
{
	header_redirect(get_url(the_module(),'index', array('notypes'=>true)));
}


$args = array(
	'fields'=>array(
		array('field'=>'title','label'=>'Título', 'type'=>'text', 'required'=>true, 'error'=>'informe o título do chamado', 'length'=>'4'),
		array('field'=>'ticket_type','label'=>'Tipo','type'=>'select', 'required'=>true,'options'=>$options, 'error'=>'informe o tipo de chamado'),
		array('field'=>'ssx_editor','label'=>'Conteúdo', 'type'=>'textarea', 'required'=>true, 'error'=>'informe o contexto do chamado'),
		array('field'=>'id', 'type'=>'hidden'),
	)	
);

$SsxEditConstruct = new SsxEditConstruct($args);
$content = "";

if(Ssx::$request->isPost() && $SsxEditConstruct->save())
{
	if($SsxProtect->checkToken())
	{
		// define a prioridade do post
		$user_group = $SsxUserGroups->getGroupByUser(SsxUsers::getUser(false));
		$rules = SsxConfig::get(Ticket::TICKET_GROUP_RULES,'serialized');
		
		$priority = 1;
		
		if($rules && $user_group && isset($rules[$user_group['id']]))
		{
			$priority = (int)$rules[$user_group['id']];
		}
		
		$data_request = $SsxEditConstruct->getDataRequest();
		$content = $data_request['ssx_editor'];
		
		if(!$data_request['title'] || !$data_request['ssx_editor'] ||  !$data_request['ticket_type'])
		{
			Ssx::$themes->assign('data_error', 'Campos como título, conteúdo e tipo de chamado precisam ser informados.');
		}else
		{
			$data_request['content'] = $data_request['ssx_editor'];
			$data_request['status'] = 1;
			$data_request['priority'] = $priority;
			
			$ticket = $Ticket->save($data_request);
			
			if($ticket)
			{
				header_redirect(get_url(the_module(), "view/".$ticket));
			}else{
				Ssx::$themes->assign('data_error', 'Erro ao criar chamado. Tente novamente.');
			}
		}
	}else{
		Ssx::$themes->assign('data_error', 'Tempo limite da requisição atingido ou os dados da requisição já venceram. Tente novamente.');
	}
}

$SsxEditor->editor($content, true);

Ssx::$themes->assign('tipos', $options);
Ssx::$themes->assign('fieldsecure', $SsxProtect->getField());
Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());