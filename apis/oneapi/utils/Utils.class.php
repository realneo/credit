<?php

class Utils {

    static function randomString($length, $chars) {
        if(!$length || $length <= 0)
            throw new Exception('Invalid random string length:'.$length);
        if(!$chars)
            throw new Exception('Invalid random string chars:'.$chars);

        $result = '';
        for($i = 0; $i < $length; $i++)
            $result .= $chars[rand(0, strlen($chars) - 1)];

        return $result;
    }

    static function randomAlphanumericString($length=null) {
        if(!$length)
            $length = 10;
        return self::randomString($length, 'qwertzuiopasdfghjklyxcvbnm123456789');
    }

    // examples:
    //  Utils::getArrayValue($array,'id', null);
    //  Utils::getArrayValue($array,array('id', 'key2'), null);
    //  Utils::getArrayValue($array,'requestError.serviceException.messageId','notfound');    
    static function getArrayValue(&$data,$name=NULL,$defval='') {   
        if($name == NULL) return($data);
        if(!is_array($data)) return($defval);
        
        if(is_array($name))
            $path = $name;
        else
            $path = explode(".", $name);

        if(sizeof($path) < 1) return $defval;
        
        $ptr=&$data; 
        for($i=0;$i < sizeof($path); $i++) {            
            $attr = $path[$i];
            if(!isset($ptr[$attr])) return $defval;
            $ptr = &$ptr[$attr];
        }
        
        // kraj
        return($ptr === NULL || (is_string($ptr) && strlen($ptr) < 1) ? $defval : $ptr);
    }

    
    // examples:
    //  Utils::setArrayValue($array,'id', $value);
    //  Utils::setArrayValue($array,array('id', 'key2'), $value);
    //  Utils::setArrayValue($array,'requestError.serviceException.messageId',$value);    
    static function setArrayValue(&$data,$name=null,$val=null) {   
        if(!is_array($data) || $name === NULL || $val === NULL) return(false);
        
        if(is_array($name))
            $path = $name;
        else
            $path = explode(".", $name);

        if(sizeof($path) < 1) return false;
        
        $ptr=&$data; 
        for($i=0;$i < sizeof($path); $i++) {            
            $attr = $path[$i];
            if(!isset($ptr[$attr])) return false;
            $ptr = &$ptr[$attr];
        }
        
        // kraj
        $ptr = $val;
        return true;
    }        
}

?>