<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'county_id',
        'name',
        'name_ar',
        'code',
        'shipping_cost',
        'postal_code'
    ];

    public function Country(){
        return $this->belongsTo(Country::class);
    }

}
