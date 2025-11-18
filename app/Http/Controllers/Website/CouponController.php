<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Traits\ResponsesTrait;
use Illuminate\Http\JsonResponse ;
use App\Http\Services\CouponService;

class CouponController extends Controller
{
    use ResponsesTrait;

    /**
     * Check coupon code is valid.
     */
    public function apply(Request $request)
    {
        try {

            $coupon_code = $request->coupon_code;
            $total_price = $request->total_price;

            $data = app(CouponService::class)->apply($coupon_code,$total_price);

            
        } catch (Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful([
            'price' => $data['price'],
            'discount' => round($total_price - $data['price'], 2),
            'coupon_type' => $data['coupon_type'],
        ]);

    }

    
}
