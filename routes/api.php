<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AuthController,ProductController,OrderController};

Route::post('login',[AuthController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);

    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('settings', SettingController::class);

});

Route::apiResources([
    'brands' => BrandController::class,
    'categories' => CategoryController::class,
]);

