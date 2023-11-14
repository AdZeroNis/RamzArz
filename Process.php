<?php
include ('crud.php');
include('apiSMScode.php');
$crud = new Crud();
function generateError($message) {
    echo json_encode([
        'status' => false,
        'message' => $message
    ]);
}
if(isset($_POST['signup'])) {
    $json=json_decode($_POST['signup'],true);
    $mobile_number= $json['mobile_number'];
    $cryptocurrency_symbol = $json['cryptocurrency_symbol'];
    $price= $json['price'];
    try {
        $checkQuery = "SELECT mobile_number FROM users WHERE mobile_number= '$mobile_number'";
        $result = $crud->getConnection()->query($checkQuery)->fetchAll();
        if (strlen($mobile_number)<11 || strlen($mobile_number)>11) {
            echo generateError("Please enter the correct number.");
        }  else {
            $verification_code = rand(1000, 9999);
            $result = $crud->execute("INSERT INTO users(mobile_number,cryptocurrency_symbol,price,verification_code) VALUES ('$mobile_number','$cryptocurrency_symbol','$price','$verification_code')");
            echo "</br>";
            sendSms($mobile_number, $verification_code);

        }
    }
    catch (PDOException $e) {
        echo generateError('Failed to connect to the database: ' . $e->getMessage());
    }
}