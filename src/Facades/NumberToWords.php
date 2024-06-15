<?php

namespace NumberToWord\NumberToWords\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NumberToWord\NumberToWords\NumberToWords
 */
class NumberToWords extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NumberToWord\NumberToWords\NumberToWords::class;
    }
}
