<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends BaseModel
{
    protected $table = 'images';

    protected $fillable = [
        'name',
        'extension',
        'url',
        'model_id',
        'model_type'
    ];

}
