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
                            `customer_email1` = :customer_email");
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
        
        // Add A new Customer
        public function add_customer($first_name, $middle_name, $last_name, $company_name, $street_name, $city_name, $country_name, $mobile1, $mobile2='', $mobile3='', $mobile4='', $email1= '', $email2=''){
            $this->db->query("INSERT INTO `customers`(`customer_reg_date`, `customer_first_name`, `customer_middle_name`, `customer_last_name`, `customer_company_name`, `customer_street_name`, `customer_city_name`, `customer_country_name`, `customer_mobile1`, `customer_mobile2`, `customer_mobile3`, `customer_mobile4`, `customer_email1`, `customer_email2`) 
                        VALUES (:reg_date, :first_name, :middle_name, :last_name, :company_name, :street_name, :city_name, :country_name, :mobile1, :mobile2, :mobile3, :mobile4, :email1, :email2)");
            $this->db->bind(':reg_date', $this->db->set_now());
            $this->db->bind(':first_name', $first_name);
            $this->db->bind(':middle_name', $middle_name);
            $this->db->bind(':last_name', $last_name);
            $this->db->bind(':company_name', $company_name);
            $this->db->bind(':street_name', $street_name);
            $this->db->bind(':city_name', $city_name);
            $this->db->bind(':country_name', $country_name);
            $this->db->bind(':email1', $email1);
            $this->db->bind(':email2', $email2);
            $this->db->bind(':mobile1', $mobile1);
            $this->db->bind(':mobile2', $mobile2);
            $this->db->bind(':mobile3', $mobile3);
            $this->db->bind(':mobile4', $mobile4);
            
            $this->db->execute();
            
            if($this->db->lastInsertId()>0){
                return true;    
            }else{
                return false;    
            }
        }
        
        public function get_customers($order_by, $order){
            $this->db->query("SELECT * FROM `customers` ORDER BY ".$order_by." ".$order);
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_customer_by_id($customer_id){
            $this->db->query("SELECT * FROM `customers` WHERE `id` = :id");
            $this->db->bind(':id', $customer_id);
            $this->db->execute();
            
            return $this->db->single();
        }
        
    }
?>