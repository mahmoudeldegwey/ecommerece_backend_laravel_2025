<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\{Order,Product};
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Mail\NewOrderCreatedEmail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth;

class OrderController extends Controller
{
    protected int $paginate = 10;

	public function index(Request $request) {
        try {

            $data = Order::with(['country','city'])
                ->select(['id','order_number','total_price','final_cost','products_count','products_quantity','status','created_at',
                    'updated_at','customer_name','customer_phone','payment_method','shipping_cost','country_id','city_id'])
            	->orderBy('orders.id','DESC')
            	->paginate($request->paginate ?? $this->paginate);

        } catch (\Exception $e) { 
            return $this->makeResponseErrors($e->getMessage());
        }

        return OrderResource::collection($data);
    }

    public function show(Order $order){
        try {

            $data = Order::with(['country','city','items.product'])
                ->where('orders.id',$order->id)
                ->select(['orders.*'])->first();
            
        } catch (\Exception $e) {
          return $this->makeResponseErrors($e->getMessage()); 
        }

        return new OrderResource($data);
    }

    public function updateStatus(OrderUpdateStatusRequest $request, Order $order){
    	try {

            $status = $request->status;
            
            if(in_array($order->status,['cancelled','refunded','delivered','refused'])){
                return $this->makeResponseErrors("order status $order->status can not change ","Errors",JsonResponse::HTTP_UNPROCESSABLE_ENTITY );
            }

            $order->status = $request->status;
            $order->save();
            
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();

    }
}
