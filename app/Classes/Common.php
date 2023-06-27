<?php

namespace App\Classes;

use Illuminate\Support\Str;

class Common
{
    public static function replaceEmptySpace(string $string)
    {
        return Str::replace(' ', '-', Str::lower($string));
    }
}
