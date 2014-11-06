<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');
    require_once('../lib/classes/Orders.php');

    $Customers = new Customers($db);
    $Orders = new Orders($db);

    $customers = $Customers->get_customers('id', 'ASC');
?>
<form id='new_order_form' name='new_order_form' action='process/new_order_process.php' method="post">   
    <p>ORDER NO: <strong><?php echo $Orders->last_id()+1; ?></strong></p>
    <select name='customer_id' id='customer_id' class='input'>
        <option value=''>Select a Customer</option>
        <?php foreach($customers as $customer){ ?>
            <option value = "<?php echo $customer['id']; ?>"><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' .$customer['customer_last_name']; ?></option>
        <?php } ?>        
    </select>
    <p></p>
    <div class='divider'></div>
    <p>Products</p>
    <?php
    $products = array(
        array('product_name'=>'Bedsheet', 'product_code'=>'B11-40', 'product_price'=>'140,000', 'product_quantity'=>2, 'product_amount'=>'280,000')
    );
    
    ?>
    <table class='table table-hover' id='order_products_display'>
        <tr>
            <th>No</th>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
    </table>
    <p></p>
    <input class='input required' type='text' id='product_name' name='product_name' value='' Placeholder='Product Name' />
    <input class='input required' type='text' id='product_code' name='product_code' value='' Placeholder='Product Code' />
    <input class='input required text-right' type='number' id='product_price' name='product_price' value='' Placeholder='Product Price' />
    <input class='input required text-right' type='number' id='product_quantity' name='product_quantity' value='' size='4' Placeholder='Quantity' />
    <input class='input required text-right' type='number' disabled name='product_amount' id='product_amount' value='' size='15' Placeholder='Amount' />
    <br />
    
    <button class='input' id='add_product_btn'><i class="fa fa-plus text-desaturated-blue"></i> Add Another Product</button>
    Total : <span class='text-11'>Tshs. </span><span class='text-bold text-right total_amount'></span>
    <p></p>
    <div class='divider'></div>
    <p></p>
    
    <p>Installment Schedule</p>
    <span class='text-11'>Tshs. </span><span class='text-bold text-right total_amount'> </span> 
    <input class='input required text-right' type='number' id='schedule_number' name='schedule_number' value='' Placeholder='Number of Instalments' />
    <input class='input required text-right' disabled type='number' id='payment_amount' name='payment_amount' value='' Placeholder='Instalment Amount' />
    <input class='input required text-right' type='number' id='payment_days' name='payment_days' value='' Placeholder='Payment Days' />
    <input class='input required text-right datepicker' type='text' id='start_date' name='start_date' value='' Placeholder='Payment Start' />
    
    <p></p>
    <div class='divider'></div>
    <p></p>
    <button class='input' id='new_order_submit' type='submit'>New Order</button>

</form>