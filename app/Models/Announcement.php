<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    protected $table = 'announcements';

    protected $fillable = [
        'name',
        'message',
        'start_at',
        'end_at',
        'is_active'
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    protected function casts(): array {
        return [
            'start_at' => 'date:M/D/Y',
            'end_at' => 'date:M/D/Y'
        ];   
    }

    public function scopeIsActive($query){
        return $query->where('is_active',1)->whereDate('start_at','<=',Carbon::now())->whereDate('end_at','>=',Carbon::now());
    }
}
