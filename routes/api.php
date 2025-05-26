<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    ProductController,
    OrderController,
    CheckoutController,
    CouponController,
    SettingController,
    BrandController,
    CategoryController,
    CsrfCookieController,
    UserController,
    RoleController,
    PermissionController,
    ColorController,
    SizeController,
    UploadImageControll
};

Route::group(['prefix' => 'dashboard'],function(){
    //Authentication
    Route::get('sanctum/csrf-cookie',[CsrfCookieController::class,'show']);
    Route::post('login',[AuthController::class,'login']);


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[AuthController::class,'getUser']);
    Route::post('logout',[AuthController::class,'logout']);

    Route::apiResources([
        'brands' => BrandController::class,
        'categories' => CategoryController::class,
        'coupons'  => CouponController::class,
        'settings' => SettingController::class,
        'products' => ProductController::class,
        'permission' => PermissionController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
        'colors' => ColorController::class,
        'sizes' => SizeController::class,
        'upload-image' => UploadImageControll::class
    ]);

    Route::apiResource('orders', OrderController::class);
});




});


Route::post('checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');