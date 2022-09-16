<?php

namespace VagKaefer\Sicoob\Facades;

use Illuminate\Support\Facades\Facade;

class Boleto extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'boleto';
    }
}
