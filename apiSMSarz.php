<?php
 function sendArz($mobile_number, $cryptocurrencySymbol, $currentPrice){
    $message = "The price of $cryptocurrencySymbol has exceeded the specified price. Current price:$currentPrice ";
    $url = "https://ippanel.com/services.jspd";
    $rcpt_nm = array($mobile_number);
    $param = array(
        'uname' => '',
        'pass' => '',
        'from' => '+9890000145',
        'message' => $message,
        'to' => json_encode($rcpt_nm),
        'op' => 'send'
    );
    
    $handler = curl_init($url);             
    curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handler);
    
    $response = json_decode($response);
    $res_code = $response[0];
    $res_data = $response[1];
    
    echo $res_data;
}
