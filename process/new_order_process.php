<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');

    $Orders = new Orders($db);

    // Get Files from From
    $customer_id = $Orders->secure_input($_POST['customer_id']);
    $total_amount = $Orders->secure_input($_POST['order_amount']);

    $new_order = $Orders->add_order($customer_id, $total_amount);
    if($new_order == true){
        return $new_order;
    }else{
        return false;
    }
?>