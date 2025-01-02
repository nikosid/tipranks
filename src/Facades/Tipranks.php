<?php

namespace Nikosid\Tipranks\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nikosid\Tipranks\Tipranks
 */
class Tipranks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Nikosid\Tipranks\Tipranks::class;
    }
}
