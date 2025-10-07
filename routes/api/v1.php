<?php

use Illuminate\Support\Facades\Route;

Route::post('/login',[\App\Http\Controllers\api\v1\AuthController::class, 'login']);
