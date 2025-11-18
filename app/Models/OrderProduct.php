<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany,HasMany,BelongsTo};

class OrderProduct extends Model
{
    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_quantity',
        'properties'
    ];

    public function order() : BelongsTo{
        return $this->belongsTo(Order::class,'order_id');
    }

    public function product() : BelongsTo{
        return $this->belongsTo(Product::class,'product_id');
    }

}
