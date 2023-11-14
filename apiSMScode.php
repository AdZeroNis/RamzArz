<?php
 function sendSms($mobile_number, $verification_code){
    $url = "https://ippanel.com/services.jspd";
    $rcpt_nm = array($mobile_number);
    $param = array(
        'uname' => '09382573820',
        'pass' => '1qaz1qaz',
        'from' => '+9890000145',
        'message' => 'Your random code is: ' . $verification_code ,
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