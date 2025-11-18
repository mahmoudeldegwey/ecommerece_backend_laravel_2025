<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasApiTokens;
    
    protected $table = 'clients';

    protected $fillable = [
        'username',
        'email',
        'password',
        'address'
    ];

    protected $hidden = ['password'];

}
