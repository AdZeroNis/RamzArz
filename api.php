<?php
include('Process.php');
include('apiSMSarz.php');
require 'vendor/autoload.php';
$crud = new Crud();

use GuzzleHttp\Client;

$client = new Client();
$url = "https://api.coinlore.net/api/tickers/";
$response = $client->get($url);

if(isset($_POST['mobile_number'])){
    try {
        $data = json_decode($response->getBody(), true);
        $mobile_number = isset($json['mobile_number']);
        $storedPriceQuery = "SELECT price, cryptocurrency_symbol FROM users WHERE mobile_number = '$mobile_number'";
        $storedPriceResult = $crud->getConnection()->query($storedPriceQuery)->fetch();
        
        $storedPrice = $storedPriceResult['price'];
        $cryptocurrencySymbol = $storedPriceResult['cryptocurrency_symbol'];
        
        $currentPrice = 0;

        foreach ($data['data'] as $ticker) {
            if ($ticker['symbol'] === $cryptocurrencySymbol) {
                $currentPrice = $ticker['price_usd'];
                break;
            }
        }
        
        if ($currentPrice <= $storedPrice) {
            sendArz($mobile_number, $cryptocurrencySymbol, $currentPrice);
        }
    } catch (Exception $e) {
        echo generateError('Failed to retrieve API data: ' . $e->getMessage());
        return;
    }
}
?>
