<?php 
namespace App\Http\Classes\Payments;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class PaymentGatewayAbstract {
    abstract public function process($currency,$amount);
    abstract public function success($token);
    abstract public function cancel();
}
