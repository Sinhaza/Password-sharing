<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
})->where('any', '^(?!api).*$');

Route::get('/password/{model:uuid}', [PasswordController::class, 'show'])
    ->middleware('signed')
    ->name('password');