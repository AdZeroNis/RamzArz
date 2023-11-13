<?php
include ('crud.php');

function generateError($message) {
    echo json_encode([
        'status' => false,
        'message' => $message
    ]);
}

$crud = new Crud();
if(isset($_POST['users'])) {
    $json=json_decode($_POST['users'],true);
    $mobile_number= $json['mobile_number'];
    $cryptocurrency_symbol = $json['cryptocurrency_symbol'];
    $price= $json['price'];
    try {
        $checkQuery = "SELECT mobile_number FROM users WHERE mobile_number= '$mobile_number'";
        $result = $crud->getConnection()->query($checkQuery)->fetchAll();
        if (empty($mobile_number)) {
            echo generateError("Please enter a mobile number.");
        } else if (count($result) > 0) {
            echo json_encode([
                'status' => true,
                'message' => "already."
            ]);
        } else {
            $result = $crud->execute("INSERT INTO users(mobile_number,cryptocurrency_symbol,price) VALUES ('$mobile_number','$cryptocurrency_symbol','$price')");
        }
    } catch (PDOException $e) {
        echo generateError( 'Failed to connect to the database.');
    }
}
