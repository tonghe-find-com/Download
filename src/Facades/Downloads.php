<?php

namespace TypiCMS\Modules\Downloads\Facades;

use Illuminate\Support\Facades\Facade;

class Downloads extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Downloads';
    }
}
