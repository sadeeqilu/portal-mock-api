<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~ E_NOTICE);
session_start();

//~ BOOTSTRAP Start
$service_dir = "/nannodit/portal-mock-api";
$log_dir = $service_dir.'/log';
$config_dir = $service_dir.'/config';
$views_dir = $service_dir.'/views';

require $service_dir . "/vendor/autoload.php";


//~ Service
$service_config_array = (new \abcvyz\lib\config(
    $config_dir.'/service_config.yaml',
    []
))->asArray();


$otp_config_array = $service_config_array['otp'];


//~ ~ Log 
$log_config_params_array = array(
    'name' => '',
    'timezone' => 'Asia/Tashkent',
    'captureSystemErrors'=> true,
    'instance' => microtime(),
    'extension' => '.log',
    'path' => $log_dir.'/main'
);
$log_config_array = (new \abcvyz\lib\config(
    $config_dir.'/log_v21_config.yaml',
    $log_config_params_array
))->asArray();

$log = new \abcvyz\lib\logger_v21($log_config_array);


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
        if(preg_match($service_config_array['operator_number_regex'],$_GET['msisdn']) != 1){
            $response = [
                "result" => [
                   "error" => [
                       "msisdn is incorrect"
                   ],
                   "isSuccess" => false
                ]
               ];
            echo json_encode($response);
        }
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
        if(preg_match($service_config_array['otp_pin_regex'],$_GET['pin']) != 1){
            $response = [
                "result" => [
                   "error" => [
                       "pin is malformed"
                   ],
                   "isSuccess" => false
                ]
               ];
            echo json_encode($response);
        }
        if(preg_match($service_config_array['otp_rid_regex'],$_GET['rid']) != 1){
            $response = [
                "result" => [
                   "error" => [
                       "rid is malformed"
                   ],
                   "isSuccess" => false
                ]
               ];
            echo json_encode($response);
        }

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