<?php

// require_once('SISendMessageResult');

/**
 * Send sms response (Social Invite) object.
 */
class SISendSmsResponse extends AbstractObject {

  public $bulkId;
  public $deliveryInfoUrl;
  public $responses;

  public function __construct($array=null, $success=true) {
      parent::__construct($array, $success);
  }
}

Models::register('SISendSmsResponse', array (
  new ObjectArrayConversionRule('SISendMessageResult', 'responses')
));

?>
