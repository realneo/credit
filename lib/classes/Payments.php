<?php

    class Payments extends Main{
        
        protected $db;
        
        public function __construct($db){
            $this->db = $db;
        }
        
       /*
        Adds a New Payment Schedule for the New Customer
        1. Inserts in the credit_payment_schedule
        2. Updates the customer -> payment_schedule_status to SET
       */
        public function add_payment_schedule($customer_id, $payment_amount, $payment_days, $start_date){
            $this->db->query("INSERT INTO `loan_payment_schedule` (`customer_id`, `payment_amount`, `payment_days`, `start_date`) 
                                VALUES (:customer_id, :payment_amount, :payment_days, :start_date)");
            
            $this->db->bind(':customer_id', $customer_id);
            $this->db->bind(':payment_amount', $payment_amount);
            $this->db->bind(':payment_days', $payment_days);
            $this->db->bind(':start_date', $start_date);
            
            $this->db->execute();
            
            if($this->db->lastInsertId()>0){
                return  'true';   
            }else{
                return  'false';    
            }
        }
    }
?>