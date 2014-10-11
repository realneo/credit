<?php

class OutboxMessage extends AbstractObject {

    public $sendDateTime;
    public $messageId;
    public $smsCount;
    public $mcc;
    public $mnc;
    public $countryCode;
    public $destinationAddress;
    public $sender;
    public $pricePerMessage;
    public $clientMetadata;
    public $messageText;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('OutboxMessage');

?>
