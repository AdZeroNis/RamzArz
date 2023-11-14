<?php
include('Process.php');
include('apiSMSarz.php');
require 'vendor/autoload.php';
$crud = new Crud();

use GuzzleHttp\Client;

$client = new Client();
$url = "https://api.coinlore.net/api/tickers/";

try {
    $response = $client->get($url);
    $data = json_decode($response->getBody(), true);
    $specifiedPriceQuery = "SELECT price FROM users";
    $specifiedPriceResult = $crud->getConnection()->query($specifiedPriceQuery)->fetch();
    $specifiedPrice = $specifiedPriceResult['price'];
    
    
    foreach ($data['data'] as $item){
        $symbol = $item['symbol'];
        $price = $item['price_usd'];
        
        if ($price >= $specifiedPrice) {
            sendArz($mobile_number, $symbol, $price);
        }
        $result=true;

        if (!$result) {
            echo generateError('Failed to store data in the database.');
            return;
        }
    }
} catch (Exception $e) {
    echo generateError('Failed to retrieve API data: ' . $e->getMessage());
    return;
}
?>
