<?php

    // Environment Settings
    
    $environment = 'localhost'; // localhost or online
    
    $db_host = 'localhost';     // Database Server
    $db_user = 'root';          // Database User
    $db_pass = 'root';          // Database Password
    $db_name = 'hsc_db';   // Database Name

    // SMS Settings
    $sms_username = 'YoteTz';
    $sms_password = 'Nadhir5566';
    $sms_sender = 'HSC';
    
    if($environment == 'localhost'){
        
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        
        define("DB_HOST", $db_host);
        define("DB_USER", $db_user);
        define("DB_PASS", $db_pass);
        define("DB_NAME", $db_name);
        
    }elseif($environment == 'online'){
        
        define("DB_HOST", $db_host);
        define("DB_USER", $db_user);
        define("DB_PASS", $db_pass);
        define("DB_NAME", $db_name);
        
    }

    define('SMS_USERNAME', $sms_username);
    define('SMS_PASSWORD', $sms_password);
    define('SMS_SENDER', $sms_sender);
?>