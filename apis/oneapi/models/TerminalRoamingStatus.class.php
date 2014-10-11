<?php

class TerminalRoamingStatus extends AbstractObject {

    public $servingMccMnc;
    public $address;
    public $currentRoaming;
    public $resourceURL;
    public $retrievalStatus;
    public $callbackData;
    public $extendedData;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'TerminalRoamingStatus',
        array(
                new SubObjectConversionRule('ServingMccMnc', 'servingMccMnc'),
                new SubObjectConversionRule('TerminalRoamingExtendedData', 'extendedData'),
        )
);

