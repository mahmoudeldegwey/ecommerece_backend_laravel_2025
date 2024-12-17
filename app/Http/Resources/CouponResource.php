<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'start_at' => $this->start_at,
            'end_at' => $this->start_at
            'type' => $this->start_at
            'amount' => $this->start_at,
            'usage' => $this->usage
        ];
    }
}
