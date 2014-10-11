<?php

class MoSubscription extends AbstractObject {

    public $subscriptionId;
    public $notifyURL;
    public $callbackData;
    public $criteria;
    public $destinationAddress;
    /* TODO
    public $notificationFormat;
    */
    public $clientCorrelator;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register('MoSubscription');

?>
