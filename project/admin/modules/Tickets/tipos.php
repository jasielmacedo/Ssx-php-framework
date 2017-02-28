<?php
/**
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * @since 19/01/2015
 * 
 */

 Ssx::$themes->ssx_module_locale->singular = "Tipos";
 Ssx::$themes->ssx_module_locale->add = "Adicionar";
 $TicketType = new TicketType();
 
 $page = Ssx::$request->fromQuery('page');
 $page = Ssx::$utils->setInt($page);
 $page--;
 $page = $page<1?0:$page;
 
 $limit = 20;
 
 $args = array(
 		'fields'=>array(
 				array('field'=>'object_name','label'=>'Tipo:', 'type'=>'text', 'required'=>true, 'error'=>'informe o tipo de chamado', 'length'=>'4'),
 				array('field'=>'id', 'type'=>'hidden'),
 		)
 );
 
 $SsxEditConstruct = new SsxEditConstruct($args);
 $id = Ssx::$request->fromFriendlyUrl(2);
 
 if(isset($id) && $id)
 {
 	if(Ssx::$request->fromQuery('delete'))
 	{
 		$TicketType->delete(array('id'=>$id));
 		header_redirect(get_url(the_module(), the_action(),array('deleted'=>true)));
 		exit;
 	} 	
 	
 	$fill = $TicketType->fill($id,false);
 	if($fill)
 	{
 		$SsxEditConstruct->setFieldsValue($fill);
 		Ssx::$themes->assign('edit', true);
 	}else
 	{
 		$id = false;
 	}
 }
 
 if($SsxEditConstruct->save())
 {
 	$data = $SsxEditConstruct->getDataRequest();
 		
 	if($TicketType->checkByName($data['object_name']) && !$id)
 	{
 		Ssx::$themes->assign('data_error', 'J&aacute; existe um tipo de chamado com esse nome');
 	}else{
 		$id = $TicketType->save($data);
 		header_redirect(get_url(the_module(), the_action(),array('saved'=>true)));
 	}
 }
 
 $args = array();
 $all = $TicketType->getAll("object_name","ASC", $limit, $page, $args,true);
 $pagination = $TicketType->mountPagination($args, $limit);
 
 Ssx::$themes->assign('all', $all);
 Ssx::$themes->assign('pagination', $pagination);
 Ssx::$themes->assign('pagination_page', $page+1);
 Ssx::$themes->assign('item_deleted', Ssx::$request->fromQuery('item_deleted'));
 Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
 Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());
 