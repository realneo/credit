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
        
        public function add_products($products_array, $order_id){
            foreach($products_array as $product){
                $this->db->query("INSERT INTO `loan_products` (`product_order_id`, `product_name`, `product_code`, `product_price`, `product_quantity`, `product_amount`) 
                                                        VALUES (:order_id, :product_name, :product_code, :product_price, :product_quantity, :product_amount)");
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':product_name', $product[1]);
                $this->db->bind(':product_code', $product[2]);
                $this->db->bind(':product_price',$product[3]);
                $this->db->bind(':product_quantity', $product[4]);
                $this->db->bind(':product_amount', $product[5]);

                $this->db->execute();
            }

        }
        
    }
?>