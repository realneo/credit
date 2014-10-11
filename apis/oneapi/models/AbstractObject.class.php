<?php

class AbstractObject {

    public $exception = null;

    public function __construct($arrayOrJson=null, $success=true) {
        // TODO: Remove this and use only the Conversions class
        if( ! $success) {
            $this->exception = new SmsException($arrayOrJson);
        } else if($arrayOrJson) {
            Logs::warn('Constructor with JSON params in '.get_class($this).' is deprecated, use Conversions utility class!');
            Conversions::fillFromJSON($this, $arrayOrJson, !$success);
        }
    }

    public function isSuccess() {
        return $this->exception === null;
    }

    public function __toString() {
        $result = '[' . get_class($this) . ':';
        $vars = get_object_vars($this);
        foreach($vars as $key => $value) {
            if(is_array($value)) {
                $result .= ':' . $key . '=' . var_export($value, true);
            } else {
                $result .= ':' . $key . '=' . $value;
            }
        }
        return $result . ']';
    }
    
}

