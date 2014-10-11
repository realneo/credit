<?

class DeliveryInfoNotification extends AbstractObject {

    public $deliveryInfo;
    public $callbackData;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'DeliveryInfoNotification',
        array(
            new SubObjectConversionRule('DeliveryInfo', 'deliveryInfo', 'deliveryInfoNotification.deliveryInfo'),
            new SubFieldConversionRule('callbackData', 'deliveryInfoNotification.callbackData')
        )
);

?>
