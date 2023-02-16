<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckApiToken;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\TimeSheetController;
use App\Http\Controllers\Api\SlotController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\NotificationController;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('check-email', [UserController::class, 'checkEmail']);
    Route::post('check-otp', [UserController::class, 'checkOtp']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('signup', [UserController::class, 'signup']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('create-auth', [UserController::class, 'createAuth']);
    Route::post('forgot-password', [UserController::class, 'forgotPassword']);
    
    Route::get('about', [UserController::class, 'about']);
    Route::get('privacy-policy', [UserController::class, 'privacyPolicy']);
    Route::get('terms-conditions', [UserController::class, 'termsConditions']);
    Route::get('get-page', [CmsController::class, 'getPage']);

    Route::get('get-category', [UserController::class, 'getCategory']);
    Route::get('get-position', [UserController::class, 'getPosition']);
    Route::get('get-setting', [UserController::class, 'getSetting']);
    Route::get('get-ums-provided', [UserController::class, 'getUmsProvided']);
    Route::get('get-covid-vaccine', [UserController::class, 'getCovidVaccine']);
});

Route::prefix('v1')->middleware([CheckApiToken::class])->group(function () {
    Route::get('get-user', [UserController::class, 'getUser']);
    Route::post('upload-timesheet', [TimeSheetController::class, 'uploadTimeSheet']);
    Route::get('my-timesheet', [TimeSheetController::class, 'myTimeSheet']);
    Route::get('slots', [SlotController::class, 'slots']);
    Route::post('save-slot', [SlotController::class, 'saveSlot']);
    Route::get('my-slots', [SlotController::class, 'mySlots']);
    Route::post('delete-slot', [SlotController::class, 'deleteSlot']);
    Route::get('jobs', [JobController::class, 'jobs']);
    Route::get('job-detail', [JobController::class, 'jobDetail']);
    Route::post('update-job', [JobController::class, 'updateJob']);
    Route::post('booking', [BookingController::class, 'booking']);
    Route::get('my-booking', [BookingController::class, 'myBooking']);
    Route::get('notifications', [NotificationController::class, 'notifications']);
    Route::post('update-user-profile', [UserController::class, 'updateUserProfile']);
    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::get('logout', [UserController::class, 'logout']);

});


Route::fallback(function () {
    return response()->json([
        'message' => 'Something went wrong. If error persists, contact to ums Team', 'success' => false
    ], 404);
});