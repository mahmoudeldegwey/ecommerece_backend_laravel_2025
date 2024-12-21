<?php 
namespace App\Http\Classes\Payments;

use Illuminate\Http\Request;    
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalGateway extends PaymentGatewayAbstract   {

    protected $payPalClient;

    public function __construct(){
        $this->payPalClient = new PayPalClient();
    }

    public function process($currency,$amount){

        $this->payPalClient->setApiCredentials(config('paypal'));

        $paypalToken = $this->payPalClient->getAccessToken();   

        $response = $this->payPalClient->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('checkout.success',['payment_method' => 'paypal_gateway']),
                "cancel_url" => route('checkout.success'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $currency,
                        "value" => $amount
                    ]
                ]
            ]
        ]); 

        return $response;

        // if (isset($response['id']) && $response['id'] != null) {            // redirect to approve href

        //     foreach ($response['links'] as $links) {
        //         if ($links['rel'] == 'approve') {
        //             return redirect()->away($links['href']);
        //         }
        //     }   

        //     return redirect()
        //         ->route('createTransaction')
        //         ->with('error', 'Something went wrong.');        
        // } 

        //     return redirect()
        //         ->route('createTransaction')
        //         ->with('error', $response['message'] ?? 'Something went wrong.');

    }

    public function success($token){
        
        $this->payPalClient->setApiCredentials(config('paypal'));
        $this->payPalClient->getAccessToken();

        return $this->payPalClient->capturePaymentOrder($token);       
    }

    public function cancel(){
        
    }
}
