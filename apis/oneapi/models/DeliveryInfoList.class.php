<?php

/**
 * The delivery status of an message.
 */
class DeliveryInfoList extends AbstractObject {

    public $deliveryInfo;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
    'DeliveryInfoList',
    new ObjectArrayConversionRule('DeliveryInfo', 'deliveryInfo', 'deliveryInfoList.deliveryInfo')
);

