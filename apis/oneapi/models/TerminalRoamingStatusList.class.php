<?php

// TODO: Remove this object and use only TerminalRoamingStatus !
class TerminalRoamingStatusList extends AbstractObject {

    public $terminalRoamingStatus;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'TerminalRoamingStatusList',
        new SubObjectConversionRule('TerminalRoamingStatus', 'terminalRoamingStatus', 'terminalRoamingStatusList.roaming')
);

