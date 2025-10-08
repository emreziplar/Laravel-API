<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\api\v1\Auth\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('/permission')->group(function () {
        Route::post('/create', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'createPermission']);
        Route::get('/get', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'getPermission']);
        Route::post('/update', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'updatePermission']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'deletePermission']);
    });


});
