<?php

class AccountBalance extends AbstractObject {

	public $balance;

	public $currency;

    public function __construct() {
        parent::__construct();
    }

}

Models::register(
        'AccountBalance',
        new SubObjectConversionRule('Currency', 'currency')
);
