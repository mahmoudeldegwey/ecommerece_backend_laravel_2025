<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Services\PaymentService;

class CheckoutController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ){

    }

    public function pay(Request $request)
    {
        try {
            
            return $this->paymentService->pay($request);

        } catch (Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function success(Request $request)
    {
        try {
               
           return $response = $this->paymentService->success($request);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }
    }


    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
         try {
               
           return $response = $this->paymentService->cancel($request);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }
    }

}
