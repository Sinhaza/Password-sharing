<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$');

Route::post('api/password', [PasswordController::class, 'store']);

Route::get('api/password/{password:uuid}', [PasswordController::class, 'show'])
    ->name('password');