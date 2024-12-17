<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ACL\Http\Services\RoleService;
use Modules\ACL\Http\Requests\{CreateRoleRequest,AssignRoleRequest};
use Illuminate\Http\Request;
use Modules\ACL\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
            
    }

    public function index(Request $request)
    {
        $request['guard'] = 'admin';
        return $this->roleService->index($request);
    }

    public function show(Role $role)
    {
        return $this->roleService->show($role);        
    }

    public function store(CreateRoleRequest $request)
    {
        $request['guard'] = 'admin';
        return $this->roleService->store($request);        
    }

    public function update(Role $role,CreateRoleRequest $request){
        return $this->roleService->update($role,$request);
    }

    public function destroy(Role $role)
    {
        return $this->roleService->destroy($role);
    }

    public function assignRoleToUser(AssignRoleRequest $request)
    {   
        return $this->roleService->assignRoleToUser($request);
    }

    public function assignPermissionToRole(Role $role, Request $request)
    {
        return $this->roleService->assignPermissionToRole($role,$request);
    }

    public function clearCache()
    {
        return $this->roleService->clearCache();
    }

}
