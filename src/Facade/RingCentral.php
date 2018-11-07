<?php

namespace Coxy121\RingCentralLaravel\Facade;

use Illuminate\Support\Facades\Facade;

class RingCentral extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'ringcentral';
    }
}
