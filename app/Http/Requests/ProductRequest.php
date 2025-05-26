<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required',
            'name_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'price' => 'required',
            'quantity' => 'required|integer',
            'main_image' => 'required|file|mimes:jpg,png,webp,jpeg',
            //'sale_price' => '',
            'sku' => 'unique:products',
            'categories' => 'required|array',
            'has_multi_color' => 'required',
            'has_multi_size' => 'required',
            'colors' => 'required_if:has_multi_color,1|array',
            // 'colors.*.color_id' => 'required',
            // 'colors.*.price' => 'required',
            // 'colors.*.image' => 'required',
            'sizes' => 'required_if:has_multi_sizes,1|array',
            'brand_id' => 'required'
        ];
    }
}
