<?php
/**
 * 
 * Plugin de configuração de pagamentos
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 */

define( 'PAGSEGURO_LOCAL', dirname(__FILE__) . '/' );


 function pagseguro_init()
 {
 	if(!defined('IS_ADMIN') || !IS_ADMIN)
 	{
 		SsxActivity::addListener('ssx_payment_options','pagseguro_method_build');
 		SsxActivity::addListener('ssx_payment_method_selected','pagseguro_method_selected');
 		SsxActivity::addListener('ssx_payment_finished','pagseguro_finished');
 	}
 }
 
 /**
  * Desenha html com os campos para pagamento
  */
 function pagseguro_method($html,$orderData)
 {
 	
 	return $html;
 }
 
 /**
  * Desenha html com o link para pagar
  * @param unknown $method
  * @param unknown $products_data
  */
 function pagseguro_method_selected($html, $method, $orderData)
 {
 	 if($method == "pagseguro")
 	 {
 	 	require PAGSEGURO_LOCAL . "PagSeguroLibrary/PagSeguroLibrary.php";
 	 	
 	 	$paymentRequest = new PagSeguroPaymentRequest();
 	 	$paymentRequest->setCurrency('BRL');
 	 	
 	 	$paymentRequest->addParameter('notificationURL', projecturl() . "ntf");
 	 	$paymentRequest->addParameter('senderCPF', $orderData->user->cpf); 
 	 	
 	 	foreach($orderData->products as $product)
 	 	{
 	 		$paymentRequest->addItem($product->id,$product->name,$product->quantity,$product->amount);
 	 	}
 	 	
 	 	/* pega credenciais */
 	 	$pagseguro_user = SsxConfig::get('pagseguro_user');
 	 	$pagseguro_chave = SsxConfig::get('pagseguro_chave');
 	 	
 	 	$credentials = new PagSeguroAccountCredentials($pagseguro_user,$pagseguro_chave);
 	 	
 	 	$url = $paymentRequest->register($credentials);
 	 	
 	 	$html .= "<a href=";
 	 }
 }
 
 function pagseguro_finished($method, $products_data)
 {
 	 
 }
 