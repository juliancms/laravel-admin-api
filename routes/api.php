<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user', [UserController::class, 'user']);
    Route::get('chart', [DashboardController::class, 'chart']);
    Route::put('users/info', [UserController::class, 'updateInfo']);
    Route::put('users/password', [UserController::class, 'updatePassword']);
    Route::post('upload_image', [ImageController::class, 'upload']);
    Route::get('export_orders', [OrderController::class, 'export']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class)->only('index', 'show');
    Route::apiResource('permissions', PermissionController::class)->only('index');
});

