<?php

class SmsException extends AbstractObject {

    public $messageId;
    public $text;
    public $variables;

    public function __construct($array=null) {
        parent::__construct($array, true);
    }

}

function __convert_sms_exception_from_json($object, $json) {
    $exception = Utils::getArrayValue(
            $json,'requestError.serviceException',
            Utils::getArrayValue($json,'requestError.policyException',null)
    );
    if($exception) {
            $object->messageId = Utils::getArrayValue($exception,'messageId','');
            $object->text = Utils::getArrayValue($exception,'text','');
            $object->variables = Utils::getArrayValue($exception,'variables',Array());
    }
}

Models::register(
        'SmsException',
        new ObjectConversionRule('__convert_sms_exception_from_json')
);
