<?php
/*
This is a sample code that uses a simple CURL function to communicate with Payprogent Payment Gateway URL.
This demo demonstrate the formula required to generate a checksum hash that will be used whether the items sent are true as per post values
The variable names are exact and must be followed for Payprogent Payment Gateway API to recognize required values to verify the checksum hash and the public key
*/
$engine_payprogent_url = 'PAYPROGENT PAYMENT GATEWAY URL HERE';
$private_key = 'PAYPROGENT PRIVATE KEY HERE';
$public_key = 'PAYPROGENT PUBLIC KEY HERE';

$site_url = 'WEBSITE AS SHOWN ON MY ACCOUNT KEY PAIRS';

$order_number = RANDOM_DATA; //this must be generated client side

$price_total_btc = $_POST['btc']; //assumed btc variable sent from previous page - this is the btc price as shown from originating page
$price_total_real = $_POST['real']; //assumed real variable sent from previous page - this is the real currency as shown from originating page

$content = array(
        'site_url' => $site_url,
        'order_number' => $order_number,
        'price_total_btc' => $price_total_btc,
        'price_total_real' => $price_total_real
);

//formula to create the checksum hash that would be used to verify content
$hash = hash_hmac('md5', json_encode( $content ), $private_key);

//keys are best sent via headers
$headers = array(
    'X-Public: '.$public_key,
    'X-Hash: '.$hash
);

//uses a CURL function to communicate with PAYPROGENT PAYMENT GATEWAY URL
$ch = curl_init($engine_payprogent_url);
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $content );

$result = curl_exec($ch);
curl_close($ch);

echo $result;