<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Orders.php');
    require_once('../lib/classes/Customers.php');

    $Orders = new Orders($db);
    $Customers = new Customers($db);

    $order_id = $_REQUEST['id'];

    $orders = $Orders->get_order_by_id($order_id);


    $timestamp = strtotime($orders['order_date']);
    $new_date = date('D - jS F, Y', $timestamp);
?>
<h2 class='text-desaturated-blue text-center'>Home Shopping Center</h2>
<h3 class='text-desaturated-blue'>Order Number: <?php echo number_format($order_id); ?> <span class='pull-right text-desaturated-blue'><?php echo $new_date; ?></span></h3>
<?php
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

<hr />


<a href='#' class='print_this no-print'>Print</a>
