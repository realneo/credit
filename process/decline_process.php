<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');

    $Orders = new Orders($db);
    
    $order_id = $_POST['id'];
    $reason = $_POST['reason'];
    $query = $Orders->update_decline($order_id, 'Declined', $reason);

    if($query == true){
        echo true;
    }else{
        echo false;    
    }
?>