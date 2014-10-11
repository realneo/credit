<?php

class Countries extends AbstractObject {

    public $countries;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'Countries',
        new ObjectArrayConversionRule('Country', 'countries')
);

?>
