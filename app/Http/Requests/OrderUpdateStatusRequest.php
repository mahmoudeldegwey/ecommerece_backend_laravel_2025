<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class OrderUpdateStatusRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'status' => ['required',Rule::in(order_statuses())], 
        ];
    }

    
}


