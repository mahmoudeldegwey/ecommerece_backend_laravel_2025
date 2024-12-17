<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends BaseModel
{
    protected $table = 'brands';

    protected $fillable = ['name','name_ar','image'];
}
