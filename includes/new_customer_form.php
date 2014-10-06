<form id='add_customer_form' name='add_customer_form' action='process/add_customer_process.php' method="post">
                   
    <p>Personal Information</p>
    
    <input class='input required' type='text' name='first_name' value='' Placeholder='First Name' />
    <input class='input required' type='text' name='middle_name' value='' Placeholder='Middle Name' />
    <input class='input required' type='text' name='last_name' value='' Placeholder='Last Name' />
    <p></p>
   
     <input class='input required' type='text' name='company_name' value='' size='50' Placeholder='Company Name' />
    <input class='input required' type='text' name='street_name' value='' Placeholder='Street Name' />
    <input class='input required' type='text' name='city_name' value='' Placeholder='City Name' />
    <p></p>
    
    <input class='input required' type='text' name='country_name' value='' Placeholder='Country Name' />
    <p></p>
   
     <div class='divider'></div>

    <p>Contact Information</p>
    
    <input class='input required' type='email' name='email1' value='' size='50' Placeholder='Personal Email' />
    <input class='input required' type='email' name='email2' value='' size='50' Placeholder='Alternate Email' />
    <p></p>
    
    <input class='input required' type='text' name='mobile1' value='' Placeholder='Mobile Number 1' />
    <input class='input' type='text' name='mobile2' value='' Placeholder='Mobile Number 2' />
    <input class='input' type='text' name='mobile3' value='' Placeholder='Mobile Number 3' />
    <input class='input' type='text' name='mobile4' value='' Placeholder='Mobile Number 4' />
    <p></p>
    
    <div class='divider'></div>
    <p></p>
    
    <button class='input' id='add_customer_submit' type='submit'>Add Customer</button>

</form>