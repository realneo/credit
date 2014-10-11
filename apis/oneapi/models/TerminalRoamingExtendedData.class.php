<?php

class TerminalRoamingExtendedData extends AbstractObject {

    public $destinationAddress;
    public $statusId;
    public $doneTime;
    public $pricePerMessage;
    public $mccMnc;
    public $servingMsc;
    public $censoredServingMsc;
    public $gsmErrorCode;
    public $originalNetworkName;
    public $portedNetworkName;
    public $servingHlr;
    public $imsi;
    public $originalNetworkPrefix;
    public $originalCountryPrefix;
    public $originalCountryName;
    public $isNumberPorted;
    public $portedNetworkPrefix;
    public $portedCountryPrefix;
    public $portedCountryName;
    public $numberInRoaming;

    public function __construct() {
        parent::__construct();
    }

}

Models::register('TerminalRoamingExtendedData');

