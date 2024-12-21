<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AuthController,ProductController,OrderController,CheckoutController,CouponController,SettingController,BrandController,CategoryController,CsrfCookieController,UserController};

//Authentication
Route::get('sanctum/csrf-cookie',[CsrfCookieController::class,'show']);
Route::post('login',[AuthController::class,'login']);

    Route::apiResource('products', ProductController::class);


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[AuthController::class,'getUser']);
    Route::post('logout',[AuthController::class,'logout']);

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('settings', SettingController::class);

});

Route::apiResources([
    'brands' => BrandController::class,
    'categories' => CategoryController::class,
]);


Route::post('checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');