<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany,HasMany,BelongsTo};

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'total_price', 
        'user_id' ,
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'country_id',
        'city_id',
        'payment_method',
        'use_different_billing_address',
        'billing_address',
        'products_count',
        'products_quantity',
        'shipping_cost',
        'final_cost',
        'coupon_applied',
        'discount_price',
        'coupon_code',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function products() : BelongsToMany {
        return $this->belongsToMany(Product::class,'order_products');
    }

    public function country() : BelongsTo {
        return $this->belongsTo(Country::class);
    }

    public function city() : BelongsTo {
        return $this->belongsTo(City::class);
    }

    public function items(): HasMany {
        return $this->hasMany(OrderProduct::class);
    }

}
