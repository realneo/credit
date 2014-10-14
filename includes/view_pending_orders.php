<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');
    require_once('../lib/classes/Users.php');

    $Orders = new Orders($db);
    $Customers = new Customers($db);
    $Users = new Users($db);

    $orders = $Orders->get_orders('id', 'ASC');
?>
<table class='table table-hover'>
  <tr>
        <th>No</th>
        <th>Date</th>
        <th>Staff</th>
        <th>Customer</th>
        <td>Amount</td>
        <th>Status</th>
        <th>Action</th>
    </tr>
   <?php 
        $count = 1;
        foreach($orders as $orders){ 
            $customers = $Customers->get_customer_by_id($orders['order_customer_id']);
            $users = $Users->get_user_profile_by_id($orders['order_staff_id']);
            foreach($customers as $customer){}
            foreach($users as $user){}
    ?>
    <tr>
        <td><?php echo $count++ ?></td>
        <td><?php echo $orders['order_date']; ?></td>
        <td><?php echo $user['first_name']. ' ' . $user['last_name']; ?></td>
        <td><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' . $customer['customer_last_name']; ?></td>
        <td><?php echo number_format($orders['order_amount']); ?></td>
        <td><?php echo $orders['order_status']; ?></td>
        <td class='order_view_details_btn'><a href=''>Details</a></td>
        <td class='order_approve_btn'><a href=''>Approve</a></td>
        <td class='order_decline_btn'><a href=''>Decline</a></td>
    </tr>
    <?php } ?>
</table>