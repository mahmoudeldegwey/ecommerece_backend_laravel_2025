<?php 
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponsesTrait;
use App\Models\Coupon;

class CouponService {

    use ResponsesTrait;

    public function apply(string $coupon_code, float $total_price)
    {
        $coupon = Coupon::IsActive()
        ->where('code',$coupon_code)
        ->whereColumn('max_usage','>','usage')->select('type','amount')->first();

        if(!$coupon) {
            return $this->makeResponse('Invalid Coupon Code',false,JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        if($coupon->type == 'fixed'){
            $price = $total_price - $coupon->amount;
        }else if($coupon->type == 'percentage'){
            $discount = ($coupon->amount / 100) * $total_price;
            $price = $total_price - $discount;
        }

        // Prevent negative price
        $price = max(0, round($price, 2));
    
        return [
            'coupon_type' => $coupon->type,
            'price' => $price
        ];

    }

   
}
