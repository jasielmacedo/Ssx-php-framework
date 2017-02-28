<?php
/**
 * 
 * 
 * @author Jasiel Macedo <jasielmacedo@gmail.com>
 * 
 */

use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Currency;
use PayPal\Api\ChargeModel;
use PayPal\Api\PatchRequest;
use PayPal\Api\Patch;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

class PayPalPlan
{
	public $apiContext;
	
	public function PayPalPlan()
	{
		$this->apiContext = PayPalContext::get(PayPalContext::clientId, PayPalContext::clientSecret);
	}
	
	public function createPlan()
	{
		// Create a new instance of Plan object
		$plan = new Plan();
		
		// # Basic Information
		// Fill up the basic information that is required for the plan
		$plan->setName('T-Shirt of the Month Club Plan')
		->setDescription('Template creation.')
		->setType('fixed');
		
		// # Payment definitions for this billing plan.
		$paymentDefinition = new PaymentDefinition();
		
		// The possible values for such setters are mentioned in the setter method documentation.
		// Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
		// You should be able to see the acceptable values in the comments.
		$paymentDefinition->setName('Regular Payments')
		->setType('REGULAR')
		->setFrequency('Month')
		->setFrequencyInterval("2")
		->setCycles("12")
		->setAmount(new Currency(array('value' => 100, 'currency' => 'BRL')));
		
		// Charge Models
		$chargeModel = new ChargeModel();
		$chargeModel->setType('SHIPPING')
		->setAmount(new Currency(array('value' => 10, 'currency' => 'BRL')));
		
		$paymentDefinition->setChargeModels(array($chargeModel));
		
		$merchantPreferences = new MerchantPreferences();
		$baseUrl = siteurl();
		// ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
		// However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
		// This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.
		$merchantPreferences->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
		->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
		->setAutoBillAmount("yes")
		->setInitialFailAmountAction("CONTINUE")
		->setMaxFailAttempts("0")
		->setSetupFee(new Currency(array('value' => 1, 'currency' => 'BRL')));
		
		
		$plan->setPaymentDefinitions(array($paymentDefinition));
		$plan->setMerchantPreferences($merchantPreferences);
		
		// For Sample Purposes Only.
		$request = clone $plan;
		
		// ### Create Plan
		try {
			$output = $plan->create($this->apiContext);
		} catch (Exception $ex) {
			//ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
			exit(1);
		}
		
		//ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);
		
		return $output;
	}
	
	public function activePlan(&$createdPlan)
	{
		try {
			$patch = new Patch();
		
			$value = new PayPalModel('{
					"state":"ACTIVE"
	     	}');
		
			$patch->setOp('replace')
				->setPath('/')
				->setValue($value);
			$patchRequest = new PatchRequest();
			$patchRequest->addPatch($patch);
		
			$createdPlan->update($patchRequest, $this->apiContext);
		
			$plan = Plan::get($createdPlan->getId(), $this->apiContext);
		
		} catch (Exception $ex) {
			//ResultPrinter::printError("Updated the Plan to Active State", "Plan", null, $patchRequest, $ex);
			exit(1);
		}
		
		//ResultPrinter::printResult("Updated the Plan to Active State", "Plan", $plan->getId(), $patchRequest, $plan);
		
		return $plan;
	}
	
	public function CreateBilling(&$createdPlan)
	{
		$agreement = new Agreement();
		
		$agreement->setName('Base Agreement')
		->setDescription('Basic Agreement')
		->setStartDate('2015-06-17T9:45:04Z');
		
		// Add Plan ID
		// Please note that the plan Id should be only set in this case.
		$plan = new Plan();
		$plan->setId($createdPlan->getId());
		$agreement->setPlan($plan);
		
		// Add Payer
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		$agreement->setPayer($payer);
		
		// Add Shipping Address
		$shippingAddress = new ShippingAddress();
		$shippingAddress->setLine1('111 First Street')
		->setCity('Saratoga')
		->setState('CA')
		->setPostalCode('95070')
		->setCountryCode('US');
		$agreement->setShippingAddress($shippingAddress);
		
		// For Sample Purposes Only.
		$request = clone $agreement;
		
		// ### Create Agreement
		try {
			// Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
			$agreement = $agreement->create($this->apiContext);
		
			// ### Get redirect url
			// The API response provides the url that you must redirect
			// the buyer to. Retrieve the url from the $agreement->getApprovalLink()
			// method
			//$approvalUrl = $agreement->getApprovalLink();
		
		} catch (Exception $ex) {
			//ResultPrinter::printError("Created Billing Agreement.", "Agreement", null, $request, $ex);
			exit(1);
		}
		
		//ResultPrinter::printResult("Created Billing Agreement. Please visit the URL to Approve.", "Agreement", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $agreement);
		
		return $agreement;
	}
}