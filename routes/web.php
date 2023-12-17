<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogbookController;
use App\Http\Middleware\StripEmptyParams;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'default'])->name('home')->middleware(StripEmptyParams::class);

# Rest endpoints
Route::post('/logbook', [LogbookController::class, 'create']);
