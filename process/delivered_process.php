<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');

    $Orders = new Orders($db);
    $Customers = new Customers($db);

    $order_id = $_POST['id'];
    $query = $Orders->update_status($order_id, 'Delivered');

    if($query){
        $order = $Orders->get_order_by_id($order_id);
        $customer = $Customers->get_customer_by_id($order['order_customer_id']);

        $balance = $customer['customer_balance'] + $order['order_amount'];

        $Customers->update_balance($order['order_customer_id'], $balance);
    }


    if($query == true){
        echo true;
    }else{
        echo false;
    }
?>
