<?php
    ob_start();
    session_start();
    
    // Defining the Root Document
    define(ROOT_DIR, $_SERVER['DOCUMENT_ROOT'] );
    
    // Set File Path for the Files
    $file_path = ROOT_DIR . DIRECTORY_SEPARATOR . "yoteyote" . DIRECTORY_SEPARATOR;
    
    
    include_once($file_path."lib/config/config.php");
    include_once($file_path."lib/classes/Main.php");
    include_once($file_path."lib/classes/Database.php");
    include_once($file_path."lib/classes/Session.php");
    
    // New Objects 
    $Session = new Session();
    $Db = new Database();

?>