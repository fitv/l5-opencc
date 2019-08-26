<?php

namespace Mvmx\OpenCC;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @method static string trans(string $text, string $configName = null)
 */
class Facade extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return OpenCC::class;
    }
}
