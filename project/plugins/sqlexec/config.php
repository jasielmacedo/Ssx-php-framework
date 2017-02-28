<?php
/**
 * 
 * @author Jasiel macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */


$args = array(
	'fields'=>array(
			array('field'=>'sql','type'=>'textarea','label'=>'Insira o Script SQL', 'required'=>true)
	)
);

$SsxEditConstruct = new SsxEditConstruct($args,true);

if(Ssx::$request->isPost())
{
	$data_request = $SsxEditConstruct->getDataRequest();
	
	if(!$data_request)
	{
		Ssx::$themes->assign('error','Houve um erro na solicitação. O Tempo limite da requisição foi excedido. Tente novamente!');
	}else
	{
		$sql = $data_request['sql'];
		
		$view = "";
		
		if(!empty($sql))
		{
			$statement = Ssx::$link->prepare($sql);
			
			if(preg_match("/(drop|truncate|create)/i",$sql))
			{	
				$view = "Erro: Comando não permitido. Caso precise realmente executar esse comando. Entre em contato com o administrador.";
			}else if(preg_match("/(select|show|insert|update|delete)/i",$sql))
			{
				try
				{
					if(preg_match("/(select|show)/i",$sql))
					{
						$return = Ssx::$link->get($statement);
						ob_start();
						print_r($return);
						$view = ob_get_clean();
					}else
					{
						Ssx::$link->changeTransition(true);
						$return = Ssx::$link->cmd($statement);
				
						$view = "Comando executado com sucesso.";
				
						if(!$return)
							$view = "Erro ao executar comando";
					}
				}catch(Exception $e)
				{
					$view = "Erro ao executar comando: <br />".$e->getMessage();
				}				
			}else{
				$view = "Erro: comando sql inválido.";
			}
		}

		Ssx::$themes->assign('view', $view);
	}
}

Ssx::$themes->assign('construct', $SsxEditConstruct->constructTable());
Ssx::$themes->assign('js_content',$SsxEditConstruct->constructValidator());