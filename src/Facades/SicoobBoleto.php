<?php

namespace VagKaefer\SicoobBoleto\Facades;

use Illuminate\Support\Facades\Facade;

class SicoobBoleto extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sicoob-boleto';
    }
}
