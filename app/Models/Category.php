<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation\{BelongsTo,HasMany};

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $fillable = ['name','name_ar','image','parent_id','is_menu','is_home'];

    public function parent() : BelongsTo{
        return $this->belongsTo($this,'parent_id');
    }

    public function childs() : HasMany{
        return $this->hasMany($this,'parent_id');
    }
}
