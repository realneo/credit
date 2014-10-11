<?php

// require_once('SISendSmsResponse');

/**
 * Social Invite response object.
 */
class SocialInviteResponse extends AbstractObject {

  public $sendSmsResponse;

  public function __construct($array=null, $success=true) {
      parent::__construct($array, $success);
  }
}

Models::register('SocialInviteResponse', array (
  new SubObjectConversionRule('SISendSmsResponse', 'sendSmsResponse')
));

?>
