<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');

    $Orders = new Orders($db);
    $SMS = new SMS();
    $Customers = new Customers($db);
    
    $order_id = $_POST['id'];
    $reason = $_POST['reason'];
    $query = $Orders->update_decline($order_id, 'Declined', $reason);
    
    $order = $Orders->get_order_by_id($order_id);
    $customer = $Customers->get_customer_by_id($order['order_customer_id']);
    $customer_mobile = $customer['customer_mobile1'];
    $customer_first_name = $customer['customer_first_name'];
    
    $SMS->send($customer_mobile, "Sorry ".$customer_first_name.", your Order No.".$order_id." is declined. REASON: ".$reason.". For more details please contact 0712 700 000");
    
    if($query == true){
        echo true;
    }else{
        echo false;    
    }
?>