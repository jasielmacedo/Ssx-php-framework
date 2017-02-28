<?php
/**
 * 
 * Configurações do plugin de pagseguro
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 * 
 */

global $plugin_id;

$args = array(
		'fields'=>array(
				array('field'=>'pagseguro_usuario','label'=>'Usuário do Pagseguro', 'type'=>'text', 'value'=>SsxConfig::get('pagseguro_usuario')),
				array('field'=>'pagseguro_chave','label'=>'Chave do Pagseguro', 'type'=>'text','value'=>SsxConfig::get('pagseguro_chave')),		
		)
);

$SsxEditConstruct = new SsxEditConstruct($args);

if($SsxEditConstruct->save())
{
	$data_request = $SsxEditConstruct->getDataRequest();
	
	SsxConfig::set('pagseguro_usuario',$data_request['pagseguro_usuario']);
	SsxConfig::set('pagseguro_chave',$data_request['pagseguro_chave']);
	
	header_redirect(get_url(the_module(), the_action()."/".$plugin_id, array('saved'=>'true')));
}


if(Ssx::$request->fromQuery('saved'))
{
	Ssx::$themes->assign('saved', 'true');
}

Ssx::$themes->assign('fields', $SsxEditConstruct->constructTable());
Ssx::$themes->assign('js_content', $SsxEditConstruct->constructValidator());