<?php

    class Customers extends Main{
        
        protected $db;
        
        public function __construct($db){
            $this->db = $db;
        }
        
        // Check if Customer exists in the Database
        
        public function check_customer_exists($first_name, $middle_name, $last_name, $email){
            $this->db->query("SELECT * FROM `customers` WHERE 
                            `customer_first_name` = :first_name AND 
                            `customer_middle_name` = :middle_name AND 
                            `customer_last_name` = :last_name AND 
                            `customer_email` = :customer_email");
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':middle_name', $middle_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':customer_email', $email);
            
            $this->db->execute();
            
            if($this->db->rowCount() > 0){
                return false;   
            }else{
                return true;   
            }
            
        }
        
    }
?>