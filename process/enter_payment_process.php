<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Payments.php');
    require_once('../lib/classes/Customers.php');

    $Payments = new Payments($db);
    $Customers = new Customers($db);

    // Getting Data from Form
    $customer_id = $_POST['customer_id'];
    $paid_date = $_POST['paid_date'];
    $amount = $_POST['amount'];

    // Add new payment process

    if($Payments->add_payment($customer_id, $amount, $paid_date)){
        $previous_balance = $Customers->check_customer_balance($customer_id)['customer_balance'];
        $balance = $previous_balance - $amount;
        $Customers->update_balance($customer_id, $balance);

        echo 'true';
    }else{
        echo 'false';
    }
?>
