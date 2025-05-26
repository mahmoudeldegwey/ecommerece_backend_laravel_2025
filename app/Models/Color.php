<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends BaseModel
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'name_ar',
        'value'
    ];

}
