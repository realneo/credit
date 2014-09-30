<?php

    class Session extends Main{
        
        public function is_user_logged_in(){
            if(isset($_SESSION['user_id'])){
                return true;
            }else{
                return false;
            }
        }
        
        public function set_user_init($id, $first_name, $last_name, $user_ip, $user_confirmed){
            $_SESSION['user_id'] = $id;
            $_SESSION['user_first_name'] = $first_name;
            $_SESSION['user_last_name'] = $last_name;
            $_SESSION['user_ip'] = $user_ip;
            $_SESSION['user_confirmed'] = $user_confirmed;
        }
    }

?>