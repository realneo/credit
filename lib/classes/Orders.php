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
                if(!$product[1]){
                    //Do Nothing    
                }else{
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
            if($this->db->lastInsertId()>0){
                return  $this->db->lastInsertId();    
            }else{
                return  false;    
            }
        }
        
        public function add_payment_schedule($order_id, $schedule_number, $payment_amount, $payment_days, $start_date){
            $this->db->query("INSERT INTO `loan_payment_schedule` (`order_id`, `schedule_number`, `payment_amount`, `payment_days`, `start_date`) 
                                    VALUES (:order_id, :schedule_number, :payment_amount, :payment_days, :start_date)");
            
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':schedule_number', $schedule_number);
            $this->db->bind(':payment_amount', $payment_amount);
            $this->db->bind(':payment_days', $payment_days);
            $this->db->bind(':start_date', $start_date);
            
            $this->db->execute();
            
            if($this->db->lastInsertId()>0){
                    return  true;   
                }else{
                    return  false;    
                }
        }
        
        public function last_id(){
            $this->db->query("SELECT `id` FROM `loan_orders` ORDER BY `id` DESC");
            $row = $this->db->single();
            if($row){
                return $row['id'];
            }else{
                return false;
            }
        }
        
        public function get_orders($order_by, $order){
            $this->db->query("SELECT * FROM `loan_orders` ORDER BY ".$order_by." ".$order);
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_order_by_id($order_id){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `id` = :id");
            $this->db->bind(':id', $order_id);
            $this->db->execute();
            
            return $this->db->single();
        }
        
        public function get_products_by_id($order_id){
            $this->db->query("SELECT * FROM `loan_products` WHERE `product_order_id` = :id");
            $this->db->bind(':id', $order_id);
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_payment_schedule_by_id($order_id){
            $this->db->query("SELECT * FROM `loan_payment_schedule` WHERE `order_id` = :id");
            $this->db->bind(':id', $order_id);
            $this->db->execute();
            
            return $this->db->single();
        }
        
        public function update_decline($order_id, $status, $reason){
            $this->db->query("UPDATE `loan_orders` SET `order_status` = :status, `order_status_reason` = :reason WHERE `id` = :id;");  
            $this->db->bind(':id', $order_id);
            $this->db->bind(':status', $status);
            $this->db->bind(':reason', $reason);
            
            $query = $this->db->execute();
            
            if($query == true){
                return true;
            }else{
                return false;   
            }
        }
        
        public function get_pendings(){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `order_status` = 'Pending' ORDER BY `id` DESC");
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_approved(){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `order_status` = 'Approved' ORDER BY `id` DESC");
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_declined(){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `order_status` = 'Declined' ORDER BY `id` DESC");
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        public function get_delivered(){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `order_status` = 'Delivered' ORDER BY `id` DESC");
            $this->db->execute();
            
            return $this->db->resultset();
        }
        
        
        public function update_status($order_id, $status){
            $this->db->query("UPDATE `loan_orders` SET `order_status` = :status WHERE `id` = :id");  
            $this->db->bind(':id', $order_id);
            $this->db->bind(':status', $status);
            
            $query = $this->db->execute();
            
            if($query == true){
                return true;
            }else{
                return false;   
            }
        }
        
        public function get_transfered(){
            $this->db->query("SELECT * FROM `loan_orders` WHERE `order_status` = 'Transfered' ORDER BY `id` DESC");
            $this->db->execute();
            
            return $this->db->resultset();
        }
    }
?>