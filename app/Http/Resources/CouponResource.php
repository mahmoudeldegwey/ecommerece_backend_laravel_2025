<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'start_at' => Carbon::parse($this->start_at)->format('M/d/Y') ,
            'end_at' => Carbon::parse($this->end_at)->format('M/d/Y'),
            'type' => $this->type,
            'amount' => $this->amount,
            'usage' => $this->usage
        ];
    }
}
