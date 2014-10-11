<?php

class MoSubscriptions extends AbstractObject {

    public $subscriptions;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'MoSubscriptions',
        new ObjectArrayConversionRule('MoSubscription', 'subscriptions')
);

?>
