<?php
namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller;
use App\Http\Services\PermissionService;
use App\Models\{Permission};
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(private PermissionService $permissionService)
    {
            
    }

    public function index(Request $request)
    {
        $request['guard'] = 'admin';
        return $this->permissionService->index($request);
    }

    public function store(Request $request)
    {
        $request['guard'] = 'admin';
        return $this->permissionService->store($request);        
    }

    public function show(Permission $permission){

    }

    public function update(Request $request)
    {
        return $this->permissionService->update($request);
    }

    public function updatePassword()
    {

    }

    public function destroy(Permission $permission)
    {

    }

}
