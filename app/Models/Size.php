<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends BaseModel
{
    protected $table = 'sizes';

    protected $fillable = [
        'name',
        'name_ar'
    ];

}
