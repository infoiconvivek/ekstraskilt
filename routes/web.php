<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Front\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[PageController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
Route::get('reset-password', [UserController::class, 'resetPassword']);
Route::post('update-user-password', [UserController::class, 'updateUserPassword']);
Route::get('account-verify', [UserController::class, 'accountVerify']);
Route::get('user-verify', [UserController::class, 'userVerify']);
});