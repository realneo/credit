<?php

/**
 * Send message response (Social Invite) object.
 */
class SISendMessageResult extends AbstractObject {

  public $messageId;
  public $status;
  public $price;

  public function __construct($array=null, $success=true) {
      parent::__construct($array, $success);
  }
}

Models::register('SISendMessageResult');

?>
