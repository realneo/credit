<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');
    
    $Orders = new Orders($db);
    $Customers = new Customers($db);

    $order_id = $_REQUEST['id'];
?>
<h2 class='text-desaturated-blue text-center'>Home Shopping Center</h2>
<h3 class='text-desaturated-blue'>Order Number: <?php echo number_format($order_id); ?> <span class='pull-right text-desaturated-blue'>2nd July 2014</span></h3>
<?php
    $orders = $Orders->get_order_by_id($order_id);
    $customer = $Customers->get_customer_by_id($orders['order_customer_id']);
    $products = $Orders->get_products_by_id($order_id);
    
?>
<p class='text-desaturated-blue'>Customer: <strong class='text-very-dark-blue'><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' . $customer['customer_last_name'];?></strong></p>
<table class='table'>
    <caption class='text-desaturated-blue'>Products</caption>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Code</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    <?php 
        $count = 0;
        $amount = 0; // This amount will increase per product_amount
        foreach($products as $product){
            $count++;
            $amount += $product['product_amount'];
    ?>
        <tr>
            <td><?php echo number_format($count); ?></td>
            <td><?php echo $product['product_name']; ?></td>
            <td><?php echo $product['product_code']; ?></td>
            <td><?php echo number_format($product['product_quantity']); ?></td>
            <td><?php echo number_format($product['product_price']); ?></td>
            <td><?php echo number_format($product['product_amount']); ?></td>
        </tr>
    <?php } ?>
        <tr>
            <th></th>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th><?php echo number_format($amount); ?></th>
        </tr>
</table>

<h4 class='text-desaturated-blue'>Payment Cycle</h4>
<table class='table-small'>
   <?php
        $payment = $Orders->get_payment_schedule_by_id($order_id);
        $start_date = $payment['start_date'];
        $timestamp = strtotime($start_date); 
        $new_date = date('D - jS F, Y', $timestamp);
    ?>
    <tr>
        <th>Total Amount</th>
        <td><?php echo $orders['order_amount']; ?></td>
    </tr>
    <tr>
        <th>Number of Installments</th>
        <td><?php echo number_format($payment['schedule_number']); ?></td>
    </tr>
    <tr>
        <th>Installment Amount</th>
        <td><?php echo number_format($payment['payment_amount']); ?></td>
    </tr>
    <tr>
        <th>Payment Days Cycle</th>
        <td><?php echo number_format($payment['payment_days']); ?> Days</td>
    </tr>
    <tr>
        <th>Start Payment Date</th>
        <td><?php echo $new_date ?></td>
    </tr>
</table>

<p class='text-desaturated-blue text-11'>
    <strong class='text-desaturated-blue'><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' . $customer['customer_last_name'];?></strong> 
    wants to take products worth Tshs.
    <strong class='text-desaturated-blue'><?php echo number_format($amount); ?></strong> 
    and will pay in <strong class='text-desaturated-blue'><?php echo number_format($payment['schedule_number']); ?></strong> Installments every <strong class='text-desaturated-blue'><?php echo number_format($payment['payment_days']); ?></strong> days amount of Tshs. <strong class='text-desaturated-blue'><?php echo number_format($payment['payment_amount']); ?></strong> starting <?php echo $new_date ?></p>


<hr />


<a href='#' class='print_this'>Print</a>