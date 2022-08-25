<?php

use Illuminate\Support\Facades\Route;
use VagKaefer\SicoobBoleto\Http\Controllers\SicoobBoletoV2Controller;

Route::get('/sicoob-boleto-webhook', [SicoobBoletoV2Controller::class, 'index'])->name('sicoob-boleto.webhook');
