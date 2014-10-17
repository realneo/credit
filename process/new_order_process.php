<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');

    $Orders = new Orders($db);
    $Customers = new Customers($db);
    $SMS = new SMS();

    // Get Files from From
    $customer_id = $Orders->secure_input($_POST['customer_id']);
    $total_amount = $Orders->secure_input($_POST['order_amount']);

    $customer = $Customers->get_customer_by_id($customer_id);
    $customer_mobile = $customer['customer_mobile1'];
    $customer_name = $customer['customer_first_name'] . ' ' .$customer['customer_last_name'];
    $total_amount_format = number_format($total_amount);

    $new_order = $Orders->add_order($customer_id, $total_amount);
    $SMS->send($customer_mobile, $customer_name . ', your credit order of Tshs '.$total_amount_format.' is being processed please wait for approval. For more details, call 0712 700 000');

    if($new_order == true){
        return $new_order;
    }else{
        return false;
    }
?>