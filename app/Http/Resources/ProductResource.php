<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'main_image' => $this->main_image,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            $this->mergeWhen($this->relationLoaded('images'), fn() => ['images' => $this->images]),
            $this->mergeWhen($this->relationLoaded('categories'), fn() => ['categories' => CategoryResource::collection($this->categories)]),
            $this->mergeWhen($this->relationLoaded('brand'), fn() => ['brand' => new BrandResource($this->brand)]),
            $this->mergeWhen($this->relationLoaded('colors'), fn() => ['colors' => BrandResource::collection($this->colors) ] ),
            $this->mergeWhen($this->relationLoaded('sizes'), fn() => ['sizes' => SizeResource::collection($this->sizes)]),
            
        ];
    }
}
