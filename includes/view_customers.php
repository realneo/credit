<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');

    $Customers = new Customers($db);

    $customers = $Customers->get_customers('id', 'ASC');
?>
<table class='table table-hover'>
  <tr>
        <th>No</th>
        <th>Company</th>
        <td>Loan Balance</td>
        <th>Full Name</th>
        <th>Mobile 1</th>
        <th>Email 1</th>
        <th>Street</th>
    </tr>
   <?php 
        $count = 1;
        foreach($customers as $customer){ 
    ?>
    <tr>
        <td><?php echo $count++ ?></td>
        <td><?php echo $customer['customer_company_name']; ?></td>
        <td><?php echo $customer['customer_balance']; ?></td>
        <td><?php echo $customer['customer_first_name'].' '. $customer['customer_middle_name'].' '. $customer['customer_last_name']; ?></td>
        <td><?php echo $customer['customer_mobile1']; ?></td>
        <td><?php echo $customer['customer_email1']; ?></td>
        <td><?php echo $customer['customer_street_name']; ?></td>
    </tr>
    <?php } ?>
</table>