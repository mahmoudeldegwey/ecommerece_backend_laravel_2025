<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'total_price' => $this->total_price,
            'final_cost' => $this->final_cost,
            'products_count' => $this->products_count,
            'products_quantity' => $this->products_quantity,
            'status' => $this->status,
            'created_at' => date($this->created_at),
            'updated_at' => date($this->updated_at),
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'payment_method' => $this->payment_method,
            'shipping_cost' => $this->shipping_cost,
            'billing_address' => json_decode($this->billing_address),
            'use_different_billing_address' => $this->use_different_billing_address,
            'country' => new CountryResource($this->whenLoaded('country')),
            'city' => new CitiesResource($this->whenLoaded('city')),
            'products' => OrderItemsResource::collection($this->whenLoaded('items'))
 
        ];
    }
}
