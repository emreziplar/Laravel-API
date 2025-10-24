<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\api\v1\Auth\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\api\v1\Auth\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\api\v1\Auth\AuthController::class, 'logout']);

    Route::prefix('/permission')->group(function () {
        Route::post('/create', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'createPermission']);
        Route::get('/get', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'getPermission']);
        Route::post('/update', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'updatePermission']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\Role\PermissionController::class, 'deletePermission']);
    });

    Route::prefix('/role')->group(function () {
        Route::post('/create', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'createRole']);
        Route::get('/get', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'getRole']);
        Route::post('/update', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'updateRole']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'deleteRole']);
        Route::middleware('accept.json')->post('/assign-permission', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'assignPermission']);
        Route::middleware('accept.json')->post('/revoke-permission', [\App\Http\Controllers\api\v1\Role\RoleController::class, 'revokePermission']);
    });

    Route::prefix('/user')->group(function () {
        Route::post('/create', [\App\Http\Controllers\api\v1\User\UserController::class, 'createUser']);
        Route::get('/get', [\App\Http\Controllers\api\v1\User\UserController::class, 'getUser']);
        Route::post('/update', [\App\Http\Controllers\api\v1\User\UserController::class, 'updateUser']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\User\UserController::class, 'deleteUser']);
    });

    Route::prefix('/category')->group(function () {
        Route::middleware('accept.json')->post('/create', [\App\Http\Controllers\api\v1\Category\CategoryController::class, 'createCategory']);
        Route::get('/get', [\App\Http\Controllers\api\v1\Category\CategoryController::class, 'getCategory']);
        Route::middleware('accept.json')->post('/update', [\App\Http\Controllers\api\v1\Category\CategoryController::class, 'updateCategory']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\Category\CategoryController::class, 'deleteCategory']);
    });

    Route::prefix('/blog')->group(function () {
        Route::middleware('accept.json')->post('/create', [\App\Http\Controllers\api\v1\Blog\BlogController::class, 'createBlog']);
        Route::get('/get', [\App\Http\Controllers\api\v1\Blog\BlogController::class, 'getBlog']);
        Route::middleware('accept.json')->post('/update', [\App\Http\Controllers\api\v1\Blog\BlogController::class, 'updateBlog']);
        Route::post('/delete', [\App\Http\Controllers\api\v1\Blog\BlogController::class, 'deleteBlog']);
    });

    Route::prefix('/media')->group(function () {
        ROute::post('/create',[\App\Http\Controllers\api\v1\Media\MediaController::class,'createMedia']);
        ROute::get('/get',[\App\Http\Controllers\api\v1\Media\MediaController::class,'getMedia']);
        ROute::post('/delete',[\App\Http\Controllers\api\v1\Media\MediaController::class,'deleteMedia']);
    });

});
