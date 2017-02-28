<?php
/**
 *  @author Jasiel Macedo <jasielmacedo@gmail.com>
 *  @version 1.0.0
 */

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


$apiContext = PayPalContext::get(PayPalContext::clientId, PayPalContext::clientSecret);


$payer = new Payer();
$payer->setPaymentMethod("paypal");

$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
->setCurrency('BRL')
->setQuantity(1)
->setPrice(7.5);

$item2 = new Item();
$item2->setName('Granola bars')
	->setCurrency('BRL')
	->setQuantity(5)
	->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping(1.2)
->setTax(1.3)
->setSubtotal(17.50);

$amount = new Amount();
$amount->setCurrency("BRL")
->setTotal(17.50);

//->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
->setItemList($itemList)
->setDescription("Payment description")
->setInvoiceNumber(uniqid());

$baseUrl = siteurl();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")
->setPayer($payer)
->setRedirectUrls($redirectUrls)
->setTransactions(array($transaction));

$request = clone $payment;

try 
{
	$payment->create($apiContext);
} catch (Exception $ex) 
{
	die($ex->getMessage());
}

$approvalUrl = $payment->getApprovalLink();

echo "Pague agora mesmo.<a href='$approvalUrl' target='_blank'>Pagar com PayPal</a>";
//ResultPrinter::printResult(, "Payment", "", $request, $payment);

