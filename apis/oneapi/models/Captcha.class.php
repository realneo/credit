<?php


class Captcha  extends AbstractObject {
    public $id;
    public $width;
    public $height;
    public $imageFormat;
    public $image;
    
    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}    
Models::register('Captcha');


?>
