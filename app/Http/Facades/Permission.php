<?php 
namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;

class Permission extends Facade {

    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \App\Http\Classes\Permission::class;
    }

}
