<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdminLog;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\MaterialeController;
use App\Http\Controllers\Admin\StorrelseController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\FestemetodeController;
use App\Http\Controllers\Admin\RammeController;
use App\Http\Controllers\Admin\BildeController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\DesignController;
use App\Http\Controllers\Admin\DesignGalleryController;
use App\Http\Controllers\Admin\DesignCategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;


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

        Route::group(['prefix' => 'order'], function () {
            Route::get('/', [AdminOrderController::class, 'index']);
            Route::get('view/{order_id}', [AdminOrderController::class, 'view']);
        });

        Route::group(['prefix' => 'payment'], function () {
            Route::get('/', [AdminPaymentController::class, 'index']);
            Route::get('view/{payment_id}', [AdminPaymentController::class, 'view']);
        });


        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('create', [UserController::class, 'create']);
            Route::post('save', [UserController::class, 'save']);
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

        Route::group(['prefix' => 'faq'], function () {
            Route::get('/', [FaqController::class, 'index']);
            Route::get('create', [FaqController::class, 'create']);
            Route::post('save', [FaqController::class, 'save']);
            Route::get('{type}/{id}', [FaqController::class, 'action']);
        });

        Route::group(['prefix' => 'menu'], function () {
            Route::get('/', [MenuController::class, 'index']);
            Route::get('create', [MenuController::class, 'create']);
            Route::post('save', [MenuController::class, 'save']);
            Route::get('{type}/{id}', [MenuController::class, 'action']);
        });

        Route::group(['prefix' => 'blog'], function () {
            Route::get('/', [BlogController::class, 'index']);
            Route::get('create', [BlogController::class, 'create']);
            Route::post('save', [BlogController::class, 'save']);
            Route::get('{type}/{id}', [BlogController::class, 'action']);
        });

        Route::group(['prefix' => 'partner'], function () {
            Route::get('/', [PartnerController::class, 'index']);
            Route::get('create', [PartnerController::class, 'create']);
            Route::post('save', [PartnerController::class, 'save']);
            Route::get('{type}/{id}', [PartnerController::class, 'action']);
        });

        Route::group(['prefix' => 'testimonial'], function () {
            Route::get('/', [TestimonialController::class, 'index']);
            Route::get('create', [TestimonialController::class, 'create']);
            Route::post('save', [TestimonialController::class, 'save']);
            Route::get('{type}/{id}', [TestimonialController::class, 'action']);
        });

        Route::group(['prefix' => 'enquiry'], function () {
            Route::get('/', [EnquiryController::class, 'index']);
            Route::get('{type}/{id}', [EnquiryController::class, 'action']);
        });

        Route::group(['prefix' => 'subscriber'], function () {
            Route::get('/', [SubscriberController::class, 'index']);
            Route::get('{type}/{id}', [SubscriberController::class, 'action']);
        });


        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('create', [CategoryController::class, 'create']);
            Route::post('save', [CategoryController::class, 'save']);
            Route::get('{type}/{id}', [CategoryController::class, 'action']);
        });

        Route::group(['prefix' => 'attribute'], function () {
            Route::get('/', [AttributeController::class, 'index']);
            Route::get('create', [AttributeController::class, 'create']);
            Route::post('save', [AttributeController::class, 'save']);
            Route::get('{type}/{id}', [AttributeController::class, 'action']);
        });

        Route::get('get-attribute-values/{attribute_id}', [ProductController::class, 'getAttributeVal']);

        Route::group(['prefix' => 'attribute-value'], function () {
            Route::get('/', [AttributeValueController::class, 'index']);
            Route::get('create', [AttributeValueController::class, 'create']);
            Route::post('save', [AttributeValueController::class, 'save']);
            Route::get('{type}/{id}', [AttributeValueController::class, 'action']);
        });


        Route::group(['prefix' => 'product-attribute'], function () {
            Route::get('/', [ProductAttributeController::class, 'index']);
            Route::get('create', [ProductAttributeController::class, 'create']);
            Route::post('save', [ProductAttributeController::class, 'save']);
            Route::get('{type}/{id}', [ProductAttributeController::class, 'action']);
        });


        Route::group(['prefix' => 'variation'], function () {
            Route::get('/', [VariationController::class, 'index']);
            Route::get('create', [VariationController::class, 'create']);
            Route::post('save', [VariationController::class, 'save']);
            Route::get('{type}/{id}', [VariationController::class, 'action']);
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('create', [ProductController::class, 'create']);
            Route::post('save', [ProductController::class, 'save']);
            Route::post('generate-variations', [ProductController::class, 'generateVariations'])->name('products.generateVariations');
            Route::get('delete-data/{type}', [ProductController::class, 'deleteData']);
            Route::get('{type}/{id}', [ProductController::class, 'action']);
        });

        Route::group(['prefix' => 'design'], function () {
            Route::get('/', [DesignController::class, 'index']);
            Route::get('create', [DesignController::class, 'create']);
            Route::post('save', [DesignController::class, 'save']);
            Route::get('tool/{id}', [DesignController::class, 'tool']);
            Route::get('get-tool-images/{id}', [DesignController::class, 'getToolImages']);
            Route::get('get-tool-bg-images/{id}', [DesignController::class, 'getToolBgImages']);
            Route::post('tool-save', [DesignController::class, 'toolSave']);
            Route::get('{type}/{id}', [DesignController::class, 'action']);
        });

        Route::group(['prefix' => 'design-category'], function () {
            Route::get('/', [DesignCategoryController::class, 'index']);
            Route::get('create', [DesignCategoryController::class, 'create']);
            Route::post('save', [DesignCategoryController::class, 'save']);
            Route::get('{type}/{id}', [DesignCategoryController::class, 'action']);
        });

        Route::group(['prefix' => 'design-gallery'], function () {
            Route::get('/', [DesignGalleryController::class, 'index']);
            Route::get('create', [DesignGalleryController::class, 'create']);
            Route::post('save', [DesignGalleryController::class, 'save']);
            Route::get('get-design-category/{id}', [DesignGalleryController::class, 'getCategory']);
            Route::get('{type}/{id}', [DesignGalleryController::class, 'action']);
        });


        Route::group(['prefix' => 'materiale'], function () {
            Route::get('/', [MaterialeController::class, 'index']);
            Route::get('create', [MaterialeController::class, 'create']);
            Route::post('save', [MaterialeController::class, 'save']);
            Route::get('{type}/{id}', [MaterialeController::class, 'action']);
        });

        Route::group(['prefix' => 'storrelse'], function () {
            Route::get('/', [StorrelseController::class, 'index']);
            Route::get('create', [StorrelseController::class, 'create']);
            Route::post('save', [StorrelseController::class, 'save']);
            Route::get('{type}/{id}', [StorrelseController::class, 'action']);
        });


        Route::group(['prefix' => 'form'], function () {
            Route::get('/', [FormController::class, 'index']);
            Route::get('create', [FormController::class, 'create']);
            Route::post('save', [FormController::class, 'save']);
            Route::get('{type}/{id}', [FormController::class, 'action']);
        });

        Route::group(['prefix' => 'festemetode'], function () {
            Route::get('/', [FestemetodeController::class, 'index']);
            Route::get('create', [FestemetodeController::class, 'create']);
            Route::post('save', [FestemetodeController::class, 'save']);
            Route::get('{type}/{id}', [FestemetodeController::class, 'action']);
        });

        Route::group(['prefix' => 'ramme'], function () {
            Route::get('/', [RammeController::class, 'index']);
            Route::get('create', [RammeController::class, 'create']);
            Route::post('save', [RammeController::class, 'save']);
            Route::get('{type}/{id}', [RammeController::class, 'action']);
        });

        Route::group(['prefix' => 'bilde'], function () {
            Route::get('/', [BildeController::class, 'index']);
            Route::get('create', [BildeController::class, 'create']);
            Route::post('save', [BildeController::class, 'save']);
            Route::get('{type}/{id}', [BildeController::class, 'action']);
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
