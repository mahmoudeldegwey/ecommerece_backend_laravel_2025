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
            'price' => formatCurrency($this->price),
            'sale_price' => !is_null($this->sale_price) ? formatCurrency($this->sale_price) : $this->sale_price,
            'discount_rate' => !is_null($this->sale_price) ? getDiscountRate($this->sale_price, $this->price) : null,
            'default_currency' => \Str::upper(setting('default_currency')),
            'main_image' => $this->main_image,
            'quantity' => $this->quantity,
            'sku' => $this->sku,
            'description' => $this->description,
            'description_ar' => $this->description_ar,
            'has_multi_color' => (boolean)$this->has_multi_color,
            'has_multi_size' => (boolean)$this->has_multi_size,
            'has_free_shipping' => (boolean)$this->has_free_shipping,
            // 'facebook_url' => $this->getShareUrl('facebook'),
            // 'x_url' => $this->getShareUrl('twitter'),
            // 'whatsapp_url' => $this->getShareUrl('whatsapp'),
            $this->mergeWhen($this->relationLoaded('images'), fn() => ['images' => $this->images]),
            $this->mergeWhen($this->relationLoaded('categories'), fn() => ['categories' => CategoryResource::collection($this->categories)]),
            $this->mergeWhen($this->relationLoaded('brand'), fn() => ['brand' => new BrandResource($this->brand)]),
            $this->mergeWhen($this->relationLoaded('colors'), fn() => ['colors' => ColorResource::collection($this->colors) ] ),
            $this->mergeWhen($this->relationLoaded('sizes'), fn() => ['sizes' => SizeResource::collection($this->sizes)]),
            
        ];
    }
}
