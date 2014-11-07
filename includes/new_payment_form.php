<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');

    $Customers = new Customers($db);

    $customers = $Customers->get_customers_with_balance();
?>
<form id='new_payment_form' name='new_payment_form' action='process/enter_payment_process.php' method="post">

    <select name='customer_id' id='customer_id' class='input'>
        <option value=''>Select a Customer</option>
        <?php foreach($customers as $customer){ ?>
            <option value = "<?php echo $customer['id']; ?>"><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' .$customer['customer_last_name']. ' - Tshs. ' . number_format($customer['customer_balance']); ?></option>
        <?php } ?>
    </select>
    <p></p>

    <div class='divider'></div>

    <p>Enter Amount Paid</p>
     <input class='input required text-right datepicker' type='text' id='paid_date' name='paid_date' value='' Placeholder='Payment Date' />
    <span class='text-11'>Tshs. </span><span class='text-bold text-right total_amount'> </span>
    <input class='input required text-right' type='number' id='amount' name='amount' value='' Placeholder='Amount' />


    <p></p>
    <div class='divider'></div>
    <p></p>
    <button class='input' id='enter_payment_submit' type='submit'>Add Payment</button>

</form>
