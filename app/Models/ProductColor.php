<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductColor extends Pivot
{
    protected $table = 'product_colors';

    protected $fillable = [
        'product_id',
        'color_id',
        'image',
        'price',
        'value'
    ];

}
