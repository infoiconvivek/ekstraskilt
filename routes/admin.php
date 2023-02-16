<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdminLog;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VaccineController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserProvidedController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\FacilityController;


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



Route::group(['prefix' => 'admin'], function () {

    Route::get('/', [AdminAuthController::class, 'login']);
    Route::get('login', [AdminAuthController::class, 'login']);
    Route::post('authenticate', [AdminAuthController::class, 'authenticate']);
    Route::get('forgot-password', [AdminAuthController::class, 'forgotPassword']);
    Route::post('reset-password-email', [AdminAuthController::class, 'resetPasswordEmail']);
    Route::get('reset-password', [AdminAuthController::class, 'resetPassword']);
    Route::post('update-admin-password', [AdminAuthController::class, 'updateAdminPassword']);

    Route::middleware([CheckAdminLog::class])->group(function () {

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
        });

        Route::group(['prefix' => 'booking'], function () {
            Route::get('/', [AdminBookingController::class, 'index']);
            Route::get('view/{booking_id}', [AdminBookingController::class, 'view']);
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('create', [UserController::class, 'create']);
            Route::post('save', [UserController::class, 'save']);
            Route::get('slots/{id}', [UserController::class, 'slots']);
            Route::get('timesheets/{id}', [UserController::class, 'timesheets']);
            Route::get('{type}/{id}', [UserController::class, 'action']);
        });


        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', [BannerController::class, 'index']);
            Route::get('create', [BannerController::class, 'create']);
            Route::post('save', [BannerController::class, 'save']);
            Route::get('{type}/{id}', [BannerController::class, 'action']);
        });

        Route::group(['prefix' => 'page'], function () {
            Route::get('/', [CmsController::class, 'index']);
            Route::get('create', [CmsController::class, 'create']);
            Route::post('save', [CmsController::class, 'save']);
            Route::get('{type}/{id}', [CmsController::class, 'action']);
        });

        Route::group(['prefix' => 'page-section'], function () {
            Route::get('/', [CmsController::class, 'sectionIndex']);
            Route::get('create', [CmsController::class, 'sectionCreate']);
            Route::post('save', [CmsController::class, 'sectionSave']);
            Route::get('{type}/{id}', [CmsController::class, 'sectionAction']);
        });



        Route::group(['prefix' => 'job'], function () {
            Route::get('/', [JobController::class, 'index']);
            Route::get('create', [JobController::class, 'create']);
            Route::post('save', [JobController::class, 'save']);
            Route::get('{type}/{id}', [JobController::class, 'action']);
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('create', [CategoryController::class, 'create']);
            Route::post('save', [CategoryController::class, 'save']);
            Route::get('{type}/{id}', [CategoryController::class, 'action']);
        });

        Route::group(['prefix' => 'provided'], function () {
            Route::get('/', [UserProvidedController::class, 'index']);
            Route::get('create', [UserProvidedController::class, 'create']);
            Route::post('save', [UserProvidedController::class, 'save']);
            Route::get('{type}/{id}', [UserProvidedController::class, 'action']);
        });


        Route::group(['prefix' => 'position'], function () {
            Route::get('/', [PositionController::class, 'index']);
            Route::get('create', [PositionController::class, 'create']);
            Route::post('save', [PositionController::class, 'save']);
            Route::get('{type}/{id}', [PositionController::class, 'action']);
        });

        Route::group(['prefix' => 'facility'], function () {
            Route::get('/', [FacilityController::class, 'index']);
            Route::get('create', [FacilityController::class, 'create']);
            Route::post('save', [FacilityController::class, 'save']);
            Route::get('{type}/{id}', [FacilityController::class, 'action']);
        });

        Route::group(['prefix' => 'vaccine'], function () {
            Route::get('/', [VaccineController::class, 'index']);
            Route::get('create', [VaccineController::class, 'create']);
            Route::post('save', [VaccineController::class, 'save']);
            Route::get('{type}/{id}', [VaccineController::class, 'action']);
        });



        Route::group(['prefix' => 'slot'], function () {
            Route::get('/', [SlotController::class, 'index']);
            Route::get('create', [SlotController::class, 'create']);
            Route::post('save', [SlotController::class, 'save']);
            Route::get('{type}/{id}', [SlotController::class, 'action']);
        });



        Route::get('setting', [DashboardController::class, 'setting']);
        Route::post('profile-update', [DashboardController::class, 'updateProfile']);
        Route::post('save-profile-image', [DashboardController::class, 'saveProfileImage']);
        Route::post('save-profile-cover-image', [DashboardController::class, 'saveProfileCoverImage']);
        Route::post('update-general-setting', [DashboardController::class, 'updateGeneralSetting']);
        Route::post('update-password', [DashboardController::class, 'updatePassword']);
        Route::get('admin-logout', [DashboardController::class, 'adminLogout']);
    });
});
