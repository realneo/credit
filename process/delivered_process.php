<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');

    $Orders = new Orders($db);
    
    $order_id = $_POST['id'];
    $query = $Orders->update_status($order_id, 'Delivered');

    if($query == true){
        echo true;
    }else{
        echo false;    
    }
?>