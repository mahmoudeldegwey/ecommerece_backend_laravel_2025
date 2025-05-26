<?php 
namespace App\Http\Services;

use App\Repositories\Interfaces\{RoleInterFace,PermissionInterFace,UserInterFace};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use App\Http\Resources\RoleResource;
use App\Filters\RoleNameFilter;
use App\Models\Role;
use App\Traits\ResponsesTrait;
use DB;

class RoleService {

    use ResponsesTrait;

    public function __construct(
        private RoleInterFace $roleInterFace,
        private UserInterFace $userInterFace,
    )
    {

    }

    public function index(Request $request){
        try {
            
            $paginate = $request->paginate ?? 2;

            $query = $this->roleInterFace->getModel()->where('guard_name',$request->guard);

            $data = app(Pipeline::class)
                ->send($query)
                ->through([
                    RoleNameFilter::class
                ])->thenReturn()->paginate($paginate);

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return RoleResource::collection($data);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{

            $role = $this->roleInterFace->create($request->role);
            $role->syncPermissions($request->permissions);

        }catch(\Exception $e){
            DB::rollBack();
            return $this->makeResponseErrors($e->getMessage());
        }
        DB::commit();

        return $this->makeResponseSuccessful();
    }

    public function show(Role $role){
        try {

            $role = $this->roleInterFace->findById($role->id);   
        
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return new RoleResource($role);
    }

    public function update(Role $role,Request $request)
    {
        try{

            $this->roleInterFace->update(['id' => $role->id],$request->role);
            $role->syncPermissions($request->permissions);

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function destroy(Role $role)
    {
        try {
            
            $role->syncPermissions([]);
            $role->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function assignRoleToUser(Request $request)
    {
        try {

            $user_id = $request->user_id;
            $role = $request->role;

            $user = $this->userInterFace->findById($user_id);
            $user->role_id = get_role_data(['name' => $role],['id'])->id;
            $user->save();
            
            $user->assignRole($role);
            
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());   
        }
        
        return $this->makeResponseSuccessful();

    }

    public function assignPermissionToRole(Role $role, Request $request)
    {
        try {

            $role->syncPermissions($request->permissions);

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());    
        }
        
        return $this->makeResponseSuccessful();
    }

    public function clearCache()
    {
        try {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();   
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage()); 
        }

        return $this->makeResponseSuccessful();
    }


}
