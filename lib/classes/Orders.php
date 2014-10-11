<?php

    class Orders extends Main{
        
        protected $db;
        
        public function __construct($db){
            $this->db = $db;
        }
        
        public function add_order($customer_id, $total_amount){
            $staff_id = 1; // This needs to be changed
            
           $this->db->query("INSERT INTO `loan_orders` 
                                (`order_date`, `order_staff_id`, `order_customer_id`, `order_amount`) 
                                VALUES (:date, :staff_id, :customer_id, :total_amount)");
            $this->db->bind(':date', $this->db->set_now());
            $this->db->bind(':staff_id', $staff_id);
            $this->db->bind(':customer_id', $customer_id);
            $this->db->bind(':total_amount', $total_amount);
            
            $this->db->execute();
            
            if($this->db->lastInsertId()>0){
                echo  $this->db->lastInsertId();    
            }else{
                echo  false;    
            }
        }
        
    }
?>