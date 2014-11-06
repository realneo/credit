<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');

    $Customers = new Customers($db);

    $customers = $Customers->get_no_payment_schedule_customers();
?>
<form id='new_payment_schedule_form' name='new_payment_schedule_form' action='process/schedule_order_process.php' method="post">   
    
    <select name='customer_id' id='customer_id' class='input'>
        <option value=''>Select a Customer</option>
        <?php foreach($customers as $customer){ ?>
            <option value = "<?php echo $customer['id']; ?>"><?php echo $customer['customer_first_name']. ' ' . $customer['customer_middle_name']. ' ' .$customer['customer_last_name']; ?></option>
        <?php } ?>        
    </select>
    <p></p>
    
    <div class='divider'></div>

    <p>Installment Schedule</p>
    <span class='text-11'>Tshs. </span><span class='text-bold text-right total_amount'> </span> 
    <input class='input required text-right' type='number' id='balance' name='balance' value='' Placeholder='Previous Balance' />
    <input class='input required text-right' type='number' id='payment_amount' name='payment_amount' value='' Placeholder='Instalment Amount' />
    <input class='input required text-right' type='number' id='payment_days' name='payment_days' value='' Placeholder='Payment Days' />
    <input class='input required text-right datepicker' type='text' id='start_date' name='start_date' value='' Placeholder='Payment Start' />
    
    <p></p>
    <div class='divider'></div>
    <p></p>
    <button class='input' id='payment_schedule_submit' type='submit'>Add Payment Schedule</button>

</form>