<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends BaseModel
{
    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'code',
        'start_at',
        'end_at',
        'type',
        'amount',
        'usage',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected function casts(): array {
        return [
            'start_at' => 'date:M/D/Y'
        ];   
    }

    public function scopeIsActive($query){
        return $query->whereDate('start_at','<=',Carbon::now())->whereDate('end_at','>=',Carbon::now());
    }

}
