<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');
    require_once('../lib/classes/Payments.php');

    $Customers = new Customers($db);
    $Payments = new Payments($db);

    $payments = $Payments->get_payments('id', 'DESC');
?>
<table class='table table-hover'>
  <tr>
        <th>No</th>
        <th>Date</th>
        <th>Customer</th>
        <th>Amount Paid</th>
        <th>Balance</th>
    </tr>
   <?php
        $count = 1;
        $total_balance = 0;
        $total_paid_amount = 0;
        foreach($payments as $payment){
            $customer = $Customers->get_customer_by_id($payment['customer_id']);
            $timestamp = strtotime($payment['date']);
            $new_date = date('D - jS F, Y', $timestamp);
            $total_balance += $customer['customer_balance'];
            $total_paid_amount += $payment['amount'];
    ?>
    <tr>
        <td><?php echo $count++ ?></td>
        <td><?php echo $new_date; ?></td>
        <td><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' . $customer['customer_last_name']; ?></td>
        <td><?php echo number_format($payment['amount']); ?></td>
        <td><?php echo $customer['customer_balance']; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th><?php echo number_format($total_paid_amount); ?></th>
        <th><?php echo number_format($total_balance); ?></th>
    </tr>
</table>
