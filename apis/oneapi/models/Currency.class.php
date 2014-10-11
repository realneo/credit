<?php

class Currency extends AbstractObject {

	public $id;
	public $currencyName;
	public $symbol;

    public function __construct() {
        parent::__construct();
    }

}

Models::register('Currency');
