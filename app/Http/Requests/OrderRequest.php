<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\{Product,Coupon};

class OrderRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'shipping_cost' => 'required',
            'final_cost' => ['required','decimal:1'],
            'total_price' => ['required','decimal:1'],
            'coupon_applied' => ['boolean'],
            //'discount_price' => ['required_if:coupon_applied,true'],
//            'discount_amount' => ['required_if:coupon_applied,true'],
            'coupon_code' => ['nullable','required_if:coupon_applied,true',Rule::exists(Coupon::class,'code')],

            'customer_name' => ['required'],
            'customer_email' => ['required','email'],
            'customer_phone' => ['required'],
            'customer_address' => ['required'],
            'country_id' => ['required'],
            'city_id' => ['required'],

            'payment_method' => ['required',Rule::in(avaliable_payment_methods())],

            'use_different_billing_address' => ['required','boolean'],
            'billing_address' => ["array"],

            'products' => 'required|array',
            'products.*.product_id' => ['required',Rule::exists(Product::class, 'id')],
            'products.*.product_quantity' => [ 'required','integer','min:1', ],
        ];
    }

    
}


