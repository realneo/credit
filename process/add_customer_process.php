<?php
    require_once('../lib/config/autoload.php');
    require_once('../lib/classes/Customers.php');

    $Customers = new Customers($db);
    $Sms = new Sms($db);
    
    // Getting & Securing Data from the Form
    $first_name = $Customers->secure_input($_POST['first_name']);
    $middle_name = $Customers->secure_input($_POST['middle_name']);
    $last_name = $Customers->secure_input($_POST['last_name']);
    $company_name = $Customers->secure_input($_POST['company_name']);
    $street_name = $Customers->secure_input($_POST['street_name']);
    $city_name = $Customers->secure_input($_POST['city_name']);
    $country_name = $Customers->secure_input($_POST['country_name']);
    $email1 = $Customers->secure_input($_POST['email1']);
    $email2 = $Customers->secure_input($_POST['email2']);
    $mobile1 = $Customers->secure_input($_POST['mobile1']);
    $mobile2 = $Customers->secure_input($_POST['mobile2']);
    $mobile3 = $Customers->secure_input($_POST['mobile3']);
    $mobile4 = $Customers->secure_input($_POST['mobile4']);

    // Adding a Post
    
    $check = $Customers->check_customer_exists($first_name, $middle_name, $last_name, $email1);
    if($check == true){
        $query = $Customers->add_customer($first_name, $middle_name, $last_name, $company_name, $street_name, $city_name, $country_name, $mobile1, $mobile2, $mobile3, $mobile4, $email1, $email2);
        if($query == true){
            $Sms->send($mobile1, $first_name. ' ' . $middle_name. ' '. $last_name.', Thank you for being our valued Customer. Please feel free to contact 0712 700 000 for any inquiries.');            
        }
    }else{
        echo 'customer_exists';
    }
?>