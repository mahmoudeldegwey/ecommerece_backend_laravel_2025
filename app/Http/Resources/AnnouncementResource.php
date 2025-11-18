<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AnnouncementResource extends JsonResource
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
            'message' => $this->message,
            'start_at' => Carbon::parse($this->start_at) ,
            'end_at' => Carbon::parse($this->end_at),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at
        ];
    }
}
