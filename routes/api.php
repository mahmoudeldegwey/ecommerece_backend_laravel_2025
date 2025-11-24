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
    UploadImageControll,
    ClientController,
    AnnouncementController,
    ProductReviewController,
    InvoiceController,
    DashboardStatisticsController
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
        'permission' => PermissionController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
        'colors' => ColorController::class,
        'sizes' => SizeController::class,
        'upload-image' => UploadImageControll::class,
        'clients' => ClientController::class,
        'orders' => OrderController::class,
        'announcements' => AnnouncementController::class,
        'product-reviews' => ProductReviewController::class
    ]);

    Route::apiResource('categories',CategoryController::class)->only(['index','store','show','destroy']);
    Route::post('categories/{category}',[CategoryController::class,'update']);

    //orders
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::put('update-status/{order}','updateStatus');
    });

    //users
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::post('update-password/{user}','updatePassword');
    });

    //clients
    Route::controller(ClientController::class)->prefix('clients')->group(function () {
        Route::post('update-password/{client}','updatePassword');
    });

    //product-reviews
    Route::controller(ProductReviewController::class)->prefix('product-reviews')->group(function () {
        Route::post('{product_review}/approve-review','approveReview');
    });

    Route::apiResource('products',ProductController::class)->only(['index','store','show','destroy']);
    Route::post('products/{product}',[ProductController::class,'update']);

    Route::get('invoice/{order}',[InvoiceController::class,'preview']);

    //dashboard statistics
    Route::get('dashboard-statistics',[DashboardStatisticsController::class,'index']);

});




});


Route::post('checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');