<?php

use Liumenggit\Helper\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('helper', Controllers\HelperController::class);


Route::resource('gethelper', Controllers\HelperApiController::class);
