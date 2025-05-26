<?php 
namespace App\Http\Classes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Permission {
    
    public function getListDashboardRoutesName()
    {
        
        $routes = Route::getRoutes();

        $prefix = 'api/dashboard';

        $filterRoutes = collect($routes)->filter(function ($route) use ($prefix) {
            return Str::startsWith($route->uri, $prefix);
        });

        $routesNames = [];

        foreach ($filterRoutes as $value) {
            array_push($routesNames,$value->getName());
        }

        $diffValuesExclude = $this->removeUnusedPermissions($routesNames);
        $permissions = [];
        
        foreach($diffValuesExclude as $key => $value){
            list($model,$name) = explode(".",$value);
            $permissions[] = [
                'model' => $model,
                'name' => $name,
                'value' => $value
            ];
        }

        return $permissions;
    }

    public function getListPortalRoutesName()
    {
        
        $routes = Route::getRoutes();

        $prefix = 'api/dashboard';

        $filterRoutes = collect($routes)->filter(function ($route) use ($prefix) {
            if (!Str::startsWith($route->uri, $prefix)) {
                return $route;
            }
        });

        $routesNames = [];

        foreach ($filterRoutes as $value) {
            array_push($routesNames,$value->getName());
        }
        
        $diffValuesExclude = $this->removeUnusedPermissions($routesNames,'customer');
        $permissions = [];
        
        foreach($diffValuesExclude as $key => $value){
            list($model,$name) = explode(".",$value);
            $permissions[] = [
                'model' => $model,
                'name' => $name,
                'value' => $value
            ];
        }

        return $permissions;
    }

    protected function removeUnusedPermissions($permissions, $guard = "admin"){

        $exclude_permissions = config('acl.exclude_permissions');
        
        if ($guard == "customer") {
            $exclude_permissions = array_merge(config('acl.exclude_portal_permissions'),config('acl.exclude_permissions'),config('acl.exclude_portal_permissions_super_admin_only'));
        }
        
        $routesNames = filter_array($permissions);

        return array_diff($routesNames,$exclude_permissions);
    }

}
