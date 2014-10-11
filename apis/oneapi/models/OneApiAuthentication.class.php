<?php

/**
 * Every client has a instance of this class that contains the basic 
 * authorization dana.
 */
class OneApiAuthentication extends AbstractObject {

	//Authentication parameters
	public $username = '';
	public $password = '';

	//IBSSO Authentication parameter
	public $ibssoToken = '';
    
    // is this session authenticated:
    public $authenticated = false;

    // is user verified:
    public $verified = false;
    
    public function __construct($array=null, $success=true) {
        parent::__construct($array, $success);

        $this->authenticated = false;
        $this->verified = false;
        $this->ibssoToken = '';
    }

}

function __convert_ib_auth_from_json($object, $json) {
    $data = Utils::getArrayValue($json,'login',Utils::getArrayValue($json,'signup',''));

    if(Utils::getArrayValue($data,'ibAuthCookie','') !== '') {
        $object->username = '';
        $object->password = '';            
        $object->ibssoToken = Utils::getArrayValue($data,'ibAuthCookie','');

        $object->authenticated = $object->ibssoToken !== '';
        $object->verified = Utils::getArrayValue($data,'verified','false') === 'true';            
    } else {
        $object->authenticated = false;
        $object->verified = false;            
    }
}

Models::register(
    'OneApiAuthentication',
    new ObjectConversionRule('__convert_ib_auth_from_json')
);

?>
