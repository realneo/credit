<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');

    $Orders = new Orders($db);
    
    // Getting Data from Form
    $order_id = $_POST['order_id'];
    $schedule_number = $_POST['schedule_number'];
    $payment_amount = $_POST['payment_amount'];
    $payment_days = $_POST['payment_days'];
    $start_date = $_POST['start_date'];

    $query = $Orders->add_payment_schedule($order_id, $schedule_number, $payment_amount, $payment_days, $start_date);

    if($query){
        echo 'true';    
    }else{
        echo 'false';    
    }

?>