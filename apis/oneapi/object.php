<?php

/** JSON <-> model conversion utilities */
class Conversions {

    /** Create new model instance from JSON. */
    public static function createFromJSON($className, $json, $isError=false) {
        if(!$className) {
            throw new Exception('Invalid className:'.$className);
        }
        $model = new $className(); 
        self::fillFromJSON($model, $json, $isError);
        return $model;
    }

    /** Fill existing model instance from JSON. */
    public static function fillFromJSON($model, $json, $isError=false) {
        if(is_array($json)) {
            $array = $json;
        } else {
            if (get_magic_quotes_gpc()) {
                $json = stripslashes($json);
            }            
            $array = json_decode($json, true);
        }

        if(!is_array($array))
            $array = array();

        if($isError) {
            $exception = self::createFromJSON('SmsException', $json, false);
            $model->exception = $exception;
            return $model;
        }

        $conversionRules = Models::getConversionRules(get_class($model));

        $className = get_class($model);

        // Keep original JSON values (for simple string values):
        foreach($array as $key => $value) {
            if(property_exists($className, $key) && (is_string($value) || is_numeric($value))) {
                $model->$key = $value;
            }
        }

        // Convert the ones that have custom conversion rules:
        foreach($conversionRules as $conversionRule) {
            foreach($array as $key => $value) {
                if($conversionRule instanceof FieldConversionRule) {
                    // field conversion rule:
                    if(property_exists($className, $key) && $conversionRule->field == $key) {
                        $model->$key = $conversionRule->convertFromJSON($value);
                    }
                } 
            }
        }
        foreach($conversionRules as $conversionRule) {
            if($conversionRule instanceof ObjectConversionRule) {
                $conversionRule->convertFromJson($model, $array);
            }
        }

        return $model;
    }

    /** Convert model to JSON. */
    public static function convertToJSON($model, $toString=false) {
        $conversionRules = Models::getConversionRules(get_class($model));
        $result = array();

        // Keep original simple values:
        $objectVars = get_object_vars($model);
        foreach($objectVars as $key => $value) {
            if(is_string($value) || is_numeric($value))
                $result[$key] = $value;
        }

        foreach($conversionRules as $conversionRule) {
            if($conversionRule instanceof FieldConversionRule) {
                $fieldName = $conversionRule->field; // TODO what if field names in JSON and in model are not the same?
                $result[$fieldName] = $conversionRule->toJSON($model->$fieldName);
            } else if($conversionRule instanceof FieldConversionRule) {
                // TODO
            }
        }

        if($toString)
            return json_encode($result);

        return $result;
    }

}

/**
 * Can be used for custom conversion rules.
 */
class FieldConversionRule {

    public $field;
    public $fromJSON;
    public $toJSON;

    public function __construct($field, $fromJSON, $toJSON) {
        $this->field = $field;
        $this->fromJSON = $fromJSON;
        $this->toJSON = $toJSON;
    }

    public function convertFromJSON($value) {
        $function = $this->fromJSON;
        return $function($value);
    }

    public function convertToJSON($value) {
        $function = $this->toJSON;
        return $function($value);
    }

}

class ObjectConversionRule {

    public $fromJSON;
    public $toJSON;

    public function __construct($fromJSON, $toJSON=null) {
        $this->fromJSON = $fromJSON;
        $this->toJSON = $toJSON;
    }

    public function convertFromJson($object, $json) {
        $function = $this->fromJSON;
        $function($object, $json);
    }

    public function convertToJson($object, $json)
    {
        $function = $this->toJSON;
        if (is_callable($function)) {
            $function($object, $json);
        } else {
            // TODO throw an exception
        }
    }

}

class SubObjectConversionRule extends ObjectConversionRule {

    private $className;
    private $objectFieldName;
    private $jsonFieldName;

    public function __construct($className, $objectFieldName, $jsonFieldName=null) {
        assert(@strlen($className) > 0);
        assert(@strlen($objectFieldName) > 0);

        $this->className = $className;
        $this->objectFieldName = $objectFieldName;
        $this->jsonFieldName = $jsonFieldName;

        if(!$this->jsonFieldName)
            $this->jsonFieldName = $objectFieldName;

    }

    public function convertFromJson($object, $json) {
        $value = Utils::getArrayValue($json, $this->jsonFieldName);

        $result = Conversions::createFromJSON($this->className, $value, false);

        $fieldName = $this->objectFieldName;
        $object->$fieldName = $result;
    }

    public function convertToJson($object, $json) {
        // TODO(TK)
    }

}

/**
 * Used when the JSON have a URL and we need to store only the last part of the url in a String variable.
 */
class SubscriptionIdFieldConversionRule extends ObjectConversionRule {

    private $objectFieldName;
    private $jsonFieldName;

    public function __construct($objectFieldName, $jsonFieldName) {
        $this->objectFieldName = $objectFieldName;
        $this->jsonFieldName = $jsonFieldName;
    }

    public function convertFromJson($object, $json) {
        $value = Utils::getArrayValue($json, $this->jsonFieldName);

        // Value is an url, the last part is the subscription id:
        $parts = explode('/', $value);
        if($value && sizeof($parts) > 0)
            $value = $parts[sizeof($parts) - 2];

        $fieldName = $this->objectFieldName;
        $object->$fieldName = $value;
    }

    public function convertToJson($object, $json) {
        // TODO(TK)
    }

}

class SubFieldConversionRule extends ObjectConversionRule {

    private $objectFieldName;
    private $jsonFieldName;

    public function __construct($objectFieldName, $jsonFieldName) {
        $this->objectFieldName = $objectFieldName;
        $this->jsonFieldName = $jsonFieldName;
    }

    public function convertFromJson($object, $json) {
        $value = Utils::getArrayValue($json, $this->jsonFieldName);
        $fieldName = $this->objectFieldName;
        $object->$fieldName = $value;
    }

    public function convertToJson($object, $json) {
        // TODO(TK)
    }

}

/**
 * Used when an object contains an array of sub-objects.
 */
class ObjectArrayConversionRule extends ObjectConversionRule {

    private $className;
    private $objectFieldName;
    private $jsonFieldName;

    public function __construct($className, $objectFieldName, $jsonFieldName=null) {
        assert($className != null);
        assert($objectFieldName != null);

        $this->className = $className;
        $this->objectFieldName = $objectFieldName;
        $this->jsonFieldName = $jsonFieldName;

        if(!$this->jsonFieldName)
            $this->jsonFieldName = $objectFieldName;

    }

    public function convertFromJson($object, $json) {
        $values = Utils::getArrayValue($json, $this->jsonFieldName);
        if(!is_array($values)) {
            Logs::warn('Looking for array (', $this->jsonFieldName, '), but found:', $values);
            return null;
        }

        $result = array();

        foreach($values as $value) {
            $result[] = Conversions::createFromJSON($this->className, $value, false);
        }

        $fieldName = $this->objectFieldName;
        $object->$fieldName = $result;
    }

    public function convertToJson($object, $json) {
        // TODO(TK)
    }

}

class Models {

    private static $conversions = array();

    public static function register($className, $conversionRules=null) {
        if($conversionRules == null)
            $conversionRules = array();

        if($conversionRules !== null && !is_array($conversionRules))
            $conversionRules = array($conversionRules);

        self::$conversions[strtolower($className)] = $conversionRules;
    }

    public static function getConversionRules($className) {
        $className = strtolower($className);
        if(!array_key_exists($className, self::$conversions)) {
            Logs::debug('Registered models:', array_keys(self::$conversions));
            throw new Exception('Unregistered model:'. $className);
        }
        return self::$conversions[$className];
    }

}

?>
