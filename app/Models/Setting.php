<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends BaseModel
{
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //protected $guarded = [];

    protected $fillable = [
        'key',
        'value'
    ];
}
