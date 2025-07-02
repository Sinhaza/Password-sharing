<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

Route::post('/password', [PasswordController::class, 'store']);
