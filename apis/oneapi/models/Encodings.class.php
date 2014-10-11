<?php

/**
 * Description of Encodings
 *
 * @author rbelusic
 */
class Encodings extends AbstractObject {

    public $encodings;

    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);
    }

}

Models::register(
        'Encodings',
        new ObjectArrayConversionRule('Encoding', 'encodings')
);
        


?>
