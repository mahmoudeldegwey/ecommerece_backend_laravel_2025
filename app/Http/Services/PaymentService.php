<?php 
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponsesTrait;
use App\Http\Classes\Payments\{PayPalGateway,StripeGateway};

class PaymentService {

    use ResponsesTrait;

    public function __construct()
    {

    }

    public function pay(Request $request)
    {
        $payment_method = $request->payment_method;
        $currency = $request->currency;
        $amount = $request->amount;
        
        $payment_gateway = $this->selectPaymentMethod($payment_method);

       return $payment_gateway->process($currency,$amount);
    }

    public function success(Request $request)
    {
        $payment_method = $request->payment_method;        
        $payment_gateway = $this->selectPaymentMethod($payment_method);

        $response =  $payment_gateway->success(token:$request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return $this->makeResponseSuccessful('Transaction complete.');
        } else {
            return $this->makeResponseErrors('Something went wrong.');
        }

    }

    public function cancel(Request $request){
        return $request->all();
    }

    protected function selectPaymentMethod($payment_method){
        return match ($payment_method) {
            'paypal_gateway' => new PayPalGateway(),
            'stripe_gateway' => new StripeGateway(),
            default => null,
        };
    }
}
