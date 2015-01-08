<?php namespace Smt\Baidupush\Facades;

use Illuminate\Support\Facades\Facade;

class Bdpush extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'bdpush'; }

}