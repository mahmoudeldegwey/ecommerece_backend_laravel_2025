<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\{
    AuthController,
    ProductController,
    CouponController,
    CityController,
    CountryController,
    OrderController,
    CategoryController,
    ProductReviewController,
    SettingController,
    AnnouncementController
};

Route::group([],function(){
    //Authentication
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);
});


Route::group(['middleware' => 'auth:api'],function(){
    Route::get('client',[AuthController::class,'getClient']);
});

Route::apiResource('products',ProductController::class);
Route::post('coupon-apply',[CouponController::class,'apply']);
Route::get('cities-by-country',[CityController::class,'citiesByCountry']);

Route::apiResource('orders', OrderController::class)->only('store');

Route::controller(CountryController::class)->prefix('countries')->group(function () {
    Route::get('/','index');
    Route::get('show','show');
});

Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/','index');
    Route::get('/{category}','show');
});

Route::apiResource('product-reviews/{product_id}', ProductReviewController::class)->only('index','store');
Route::apiResource('settings', SettingController::class)->only('index');
Route::apiResource('announcements', AnnouncementController::class)->only('index');
