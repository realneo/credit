<?php
    ob_start();
    session_start();
    
    // Defining the Root Document
    define(ROOT_DIR, $_SERVER['DOCUMENT_ROOT'] );
    
    // Set File Path for the Files
    $file_path = ROOT_DIR . DIRECTORY_SEPARATOR . "credit" . DIRECTORY_SEPARATOR;
    
    
    include_once($file_path."lib/config/config.php");
    include_once($file_path."lib/classes/Main.php");
    include_once($file_path."lib/classes/Database.php");
    include_once($file_path."lib/classes/Session.php");
    include_once($file_path."lib/classes/SMS.php");
    
    
    

    // New Objects 
    $Session = new Session();
    $db = new Database();

?>