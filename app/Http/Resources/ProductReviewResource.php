<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'image' => $this->image,
            'rate' => $this->rate,
            'message' => $this->message,
            'status' => $this->status,
            'created_at' => $this->created_at,
            $this->mergeWhen($this->relationLoaded('product'), [
                'product' => new ProductResource($this->product),
            ]),
        ];
    }
}
