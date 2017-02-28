<?php
/**
 * 
 * Classe de organização e centralização dos dados da API
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * @version 1.0
 * 
 */

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalContext
{
	const clientId = "Aefj0G8vN8zmdGY7wQEKn9q5uRzQ6SyvxDO0U8bhLVZ7zetq31NH-vyQdN9D2_1PWczKLowHN7NkN4QT";
	const clientSecret = "EP5I5HjQgh4SfqtB_oOM31zgLWLj1aC1iemItKEv_bINxrxqZAhSx85n-5PhivPZRa-MdQiyiOoqEdfQ";
	
	public static function get($clientId, $clientSecret)
	{

		
		$apiContext = new ApiContext(
				new OAuthTokenCredential(
						$clientId,
						$clientSecret
				)
		);
		
		$apiContext->setConfig(
	        array(
	            'mode' => 'sandbox',
	            'log.LogEnabled' => true,
	            'log.FileName' => '../PayPal.log',
	            'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
	            'validation.level' => 'log',
	            'cache.enabled' => true,
	            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
	            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
	        )
	    );		
		
		return $apiContext;
	}
}

