<?php
namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\{Order,OrderProduct,Product};
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Mail\NewOrderCreatedEmail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\CouponService;
use DB;
use Auth;

class OrderController extends Controller
{
    public function store(OrderRequest $request) : JsonResponse|JsonResource{
    	
    	try {
    		
            DB::beginTransaction();

    		$products = [];
    		$total_price = 0;
            $products_quantity = 0;
            $total_price = 0;

    		foreach (collect($request->products) as $data) {
                
                $products_quantity += $data['product_quantity'];                
    			$products[] = [
    				'product_id' => $data['product_id'],
    				'product_quantity' => $data['product_quantity'],
                    'properties' => json_encode($data['properties'])
    			];

                $product = Product::where('id',$data['product_id'])->select('price','sale_price','id','quantity')->first();

                if($product){
                    $total_price += !is_null($product->sale_price) ? $product->sale_price : $product->price;
                    $total_price = $total_price * $data['product_quantity'];
                }

    		}

            $couponData = [];
            $coupon_applied = $request->coupon_applied;
            $shipping_cost = $request->shipping_cost;
            $final_cost = $total_price + $request->shipping_cost;
            $discount_price = null;

            if($coupon_applied && !is_null($request->coupon_code)){
                $couponData = app(CouponService::class)->apply($request->coupon_code,$total_price);
                $discount_price = isset($couponData['price']) ? round($total_price - $couponData['price'], 2) : null;
                $final_cost = ($total_price - $discount_price) + $shipping_cost ;
            }

			$order = Order::create([
    			'order_number' => 'OR'.strtotime(date('h:m:i')),
    			'status' => 'pending',
    			'products_count' => count($request->products),
                'products_quantity' => $products_quantity,
                'shipping_cost' => $request->shipping_cost,
                'final_cost' => $final_cost,
                'coupon_applied' => $request->coupon_applied,
                'discount_price' => $discount_price,
                'coupon_code' => $request->coupon_code,
    			'total_price' => $total_price,
                'user_id' => Auth::user()?->id,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'payment_method' => $request->payment_method,
                'use_different_billing_address' => $request->use_different_billing_address,
                'billing_address' => json_encode($request->billing_address),
    		]);

    		$order->products()->sync($products);
            
            DB::commit();

            Mail::to('test@yahoo.com')->send(new NewOrderCreatedEmail($order));

    	} catch (\Exception $e) {
    		DB::rollback();
    		return response()->json(["error" => true , "message" => $e->getMessage()] , JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    	}

    	return new OrderResource($order);
    }
}
