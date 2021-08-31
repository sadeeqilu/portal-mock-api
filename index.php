<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~ E_NOTICE);
session_start();


if(!isset($_GET['pin'])){
    if(!isset($_GET['msisdn'])){
        $response = [
            "result" => [
               "error" => [
                   "msisdn is missing"
               ],
               "isSuccess" => false
            ]
           ];
       echo json_encode($response);
    }
    else{
        $otp = strval(rand(1000, 9999));
        $_SESSION['session_otp'] = $otp;
        $_SESSION['msisdn'] = $_GET['msisdn'];
        $response = [
            "result" => [
                "msisdn" => $_GET['msisdn'],
                "pin" => $otp,
                "rid" => "12:1234",
                "level" => 1,
                "points" => 123,
                "isSuccess" => true
                ]
            ];
        echo json_encode($response);
    }
}
else{

    if(!isset($_GET['rid'])){
        $response = [
            "result" => [
               "error" => [
                   "pin is present but rid is absent"
               ],
               "isSuccess" => false
            ]
           ];
       echo json_encode($response);
    }
    if (!isset($_GET['pin'])) {
        $response = [
            "result" => [
                "msisdn" => "998881674567",
                "error" => [
                    "pin mismatch"
                ],
                "isSuccess" => false
            ]
            ];
        echo json_encode($response);
    } else {
        unset($_SESSION['session_otp']);
        $token = rand(1,2);
        if($token == 1)
            $token = "0";
        else $token = "38";

        if($token == "0"){
            $response = [
                "result" => [
                    "msisdn" => "998881674567",//$_SESSION['msisdn'],
                    "token" => "0",
                    "level" => 1,
                    "points" => 123,
                    "openInvoice" => "0",
                    "isSuccess" => true
                ]
            ];  
        echo json_encode($response);

        }
        else{
            $response = [
                "result" => [
                    "msisdn" => "998881674567",//$_SESSION['msisdn'],
                    "token" => "38",
                    "level" => 1,
                    "points" => 123,
                    "isSuccess" => true
                ]
            ];  
            echo json_encode($response);
        }
        
    }
}
?>