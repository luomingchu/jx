<?php namespace Smt\Unionpay\Facades;

use Illuminate\Support\Facades\Facade;

class Unionpay extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'unionpay'; }

}