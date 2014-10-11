<?


class TerminalRoamingStatusNotification extends AbstractObject {

    public $terminalRoamingStatus;
    public $callbackData;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'TerminalRoamingStatusNotification',
        array(
            new SubObjectConversionRule('TerminalRoamingStatus', 'terminalRoamingStatus', 'terminalRoamingStatusList.roaming'),
            new SubFieldConversionRule('callbackData', 'terminalRoamingStatusList.roaming.callbackData')
        )
);

?>
