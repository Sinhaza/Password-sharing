<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::post('/password', [PasswordController::class, 'store']);

Route::get('/password/{uuid}', [PasswordController::class, 'show'])
    ->middleware('signed')
    ->name('password');