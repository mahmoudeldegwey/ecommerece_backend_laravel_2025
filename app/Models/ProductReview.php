<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation\BelongsTo;

class ProductReview extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = [
        'product_id',
        'client_id',
        'username',
        'email',
        'phone_number',
        'image',
        'rate',
        'status',
        'message'
    ];

    public function product()  {
        return $this->belongsTo(Product::class,'product_id');
    }
}
