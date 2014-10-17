<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');
    require_once('../lib/classes/Users.php');

    $Orders = new Orders($db);
    $Customers = new Customers($db);
    $Users = new Users($db);

    $orders = $Orders->get_transfered();
?>
<table class='table table-hover'>
  <tr>
        <th>No</th>
        <th>Date</th>
        <th>Order ID</th>
        <th>Staff</th>
        <th>Customer</th>
        <td>Amount</td>
        <th>Status</th>
        <th class='no-print'>Action</th>
    </tr>
   <?php 
        $count = 1;
        foreach($orders as $orders){ 
            $customer = $Customers->get_customer_by_id($orders['order_customer_id']);
            $users = $Users->get_user_profile_by_id($orders['order_staff_id']);
            foreach($users as $user){}
    ?>
    <tr>
        <td><?php echo $count++ ?></td>
        <td><?php echo $orders['order_date']; ?></td>
        <td><?php echo $orders['id']; ?></td>
        <td><?php echo $user['first_name']. ' ' . $user['last_name']; ?></td>
        <td><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' . $customer['customer_last_name']; ?></td>
        <td><?php echo number_format($orders['order_amount']); ?></td>
        <td><?php echo $orders['order_status']; ?></td>
        <td class='order_view_details_btn no-print'><a href=''>Details</a></td>
        <td class='order_delivered_btn no-print'><i class='fa fa-check text-desaturated-blue'></i> <a href='' class='text-desaturated-blue'>Delivered</a></td>
    </tr>
    <?php } ?>
</table>