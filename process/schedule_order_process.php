<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Payments.php');
    require_once('../lib/classes/Customers.php');

    $Payments = new Payments($db);
    $Customers = new Customers($db);
    
    // Getting Data from Form
    $customer_id = $_POST['customer_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_days = $_POST['payment_days'];
    $start_date = $_POST['start_date'];

    // Check if customer Schedule is already SET
    if($Customers->check_payment_schedule_status_by_id($customer_id) == false){
    
    $query = $Payments->add_payment_schedule($customer_id, $payment_amount, $payment_days, $start_date);

    if($query){
        $q = $Customers->update_payment_schedule_status($customer_id, 'SET');
        if($q){
            echo 'true'; 
        }else{
            echo 'false';    
        }
    }
    }else{
        echo 'false';   
    }
?>