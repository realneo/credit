<?php

class DeliveryReportSubscriptions extends AbstractObject {

    public $subscriptionId;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'DeliveryReportSubscriptions',
        new ObjectArrayConversionRule('DeliveryReportSubscription', 'deliveryReceiptSubscriptions')
);
