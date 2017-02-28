<?php
/**
 * 
 * Tentativa de requisição ajax diretamente no servidor informando os dados corretamente
 * 
 * 
 */

$data_url = "function_call=SsxAjaxPages_generateslug&function_data%5Btitle%5D=teste&function_data%5Btoken%5D=MTAwNDYyN2VhMzU5ODM1Y2Q3MmFlNmYwYjZlYzAzZDgyOGZkNzhjMQ%3D%3D&function_callback=1&output=json&ad=true";

$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL,"http://gateway.skyjaz.com/");

curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);

curl_setopt($ch, CURLOPT_REFERER, 'http://gateway.skyjaz.com/ssxpages/edit');

$dir = dirname(__FILE__);

$config['cookie_file'] = $dir . "/cookie.txt";

curl_setopt($ch, CURLOPT_COOKIEFILE, $config['cookie_file']);
curl_setopt($ch, CURLOPT_COOKIEJAR, $config['cookie_file']);

curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);    

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = array();
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Accept-Language: en-US,en;q=0.5';
$headers[] = 'Content-Length:'.strlen($data_url);
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Host: gateway.skyjaz.com';
$headers[] = 'Origin: http://gateway.skyjaz.com';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch,CURLOPT_HEADER,0);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_url);


$html=curl_exec($ch);
$http = curl_getinfo($ch);
var_dump($http);
var_dump($html);