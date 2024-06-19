<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserLog;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\StripeController;
use App\Http\Controllers\Front\ToolController;

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
Route::get('products-list',[ProductController::class, 'productsList']);
Route::get('products',[ProductController::class, 'products']);
Route::get('product/{slug}',[ProductController::class, 'productDetail']);
Route::get('cart',[PageController::class, 'cart']);
Route::get('wishlist',[WishlistController::class, 'wishlist']);

Route::get('privacy-policy',[PageController::class, 'privacyPolicy']);
Route::get('terms-condition',[PageController::class, 'termCondition']);
Route::get('who-we-are',[PageController::class, 'whoWeAre']);

Route::get('faq',[PageController::class, 'faq']);
Route::get('elegant-grid',[PageController::class, 'elegantGrid']);
Route::get('elegant-ribbon',[PageController::class, 'elegantRibbon']);
Route::get('utilities-sales',[PageController::class, 'utilitiesSales']);

Route::get('distributors',[PageController::class, 'distributors']);
Route::get('affiliates',[PageController::class, 'affiliates']);

Route::get('track',[PageController::class, 'track']);
Route::get('about-us',[PageController::class, 'aboutUs']);

Route::get('contact-us',[PageController::class, 'contactUs']);
Route::post('save-enquiry', [PageController::class, 'saveEnquiry'])->name('save-enquiry');
Route::get('refresh-captcha', [PageController::class, 'refreshCaptcha'])->name('refreshCaptcha');
Route::get('blogs',[PageController::class, 'blogs']);
Route::get('blog/{slug}',[PageController::class, 'blogDetails']);
Route::get('login',[UserController::class, 'login']);
Route::get('forgot-password',[UserController::class, 'forgotPassword']);
Route::post('send-reset-pass-link', [UserController::class, 'sendResetPassLink']);
Route::post('reset-password-email',[UserController::class,'resetPasswordEmail']);
Route::post('update-user-email-password',[UserController::class,'updateUserEmailPassword']);
Route::get('save-newsletter',[NewsletterController::class, 'saveNewsletter']);
Route::get('register',[UserController::class, 'register']);
Route::post('user-auth/{type}',[UserController::class, 'userAuth']);

Route::any('add-cart',[CartController::class, 'addToCart']);
Route::any('delete-cart/{id}',[CartController::class, 'deleteCart']);
Route::get('cart',[CartController::class, 'cart']);
Route::any('checkout',[OrderController::class, 'checkout']);
Route::get('order-confirm',[OrderController::class, 'orderConfirm']);

Route::middleware([CheckUserLog::class])->group(function () {
Route::post('place-order',[OrderController::class, 'placeOrder']);
Route::get('stripe', [StripeController::class, 'stripePage'])->name('stripe');
Route::post('stripe-pay', [StripeController::class, 'stripePay'])->name('stripe-pay');
Route::get('success-stripe-payment', [StripeController::class, 'successStripePayment'])->name('success-stripe-payment');
});

Route::group(['prefix' => 'tool'], function () {
    Route::get('/',[ToolController::class, 'index']);
});
Route::group(['prefix' => 'user'], function () {
Route::get('myaccount',[UserController::class, 'myaccount']);    
Route::middleware([CheckUserLog::class])->group(function () {
Route::get('orders',[UserController::class, 'orders']);    
Route::get('order-details/{id}',[UserController::class, 'orderDetails']);
Route::get('my-profile',[UserController::class, 'myProfile']);
Route::post('update-profile', [UserController::class, 'updateProfile']);
Route::get('change-password',[UserController::class, 'changePassword']);
Route::get('reset-password', [UserController::class, 'resetPassword']);
Route::post('update-user-password', [UserController::class, 'updateUserPassword']);
Route::get('account-verify', [UserController::class, 'accountVerify']);
Route::get('user-verify', [UserController::class, 'userVerify']);
Route::get('logout',[UserController::class, 'logout']);
});
});
