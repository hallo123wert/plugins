<?php

use Hallo123wert\BlueMap\Http\Controllers\BlueMapProxyController;
use Illuminate\Support\Facades\Route;

Route::get('{uuid}/{path?}', BlueMapProxyController::class)
    ->where('path', '.*')
    ->name('bluemap.proxy');
