<?php 
namespace App\Http\Classes\Payments;

use Illuminate\Http\Request;    
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe;
use Stripe\StripeClient;

class StripeGateway extends PaymentGatewayAbstract   {

    protected $stripeClient;

    public function __construct(){
        $this->stripeClient = $stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function process($currency,$amount){
        $response = $this->stripeClient->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                  'currency' => $currency,
                  'product_data' => [
                    'name' => 'Payment checkout',
                  ],
                  'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success',['payment_method' => 'stripe_gateway']),
            'cancel_url' => route('checkout.cancel',['payment_method' => 'stripe_gateway']),
        ]);

        return $response;
    }

    public function success(?string $token = ""){
        return ['status' => 'COMPLETED'];
        //return response()->json(,201);
    }

    public function cancel(){
        
    }
}
