<?php 
namespace App\Http\Services;

use App\Http\Repositories\Interfaces\{RoleInterFace,PermissionInterFace,UserInterFace};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Modules\ACL\Http\Resources\RoleResource;
use App\Http\Filters\RoleNameFilter;
use App\Http\Models\Role;
use DB;

class RoleService {

    public function __construct(
        private RoleInterFace $roleInterFace,
        private UserInterFace $userInterFace,
    )
    {

    }

    public function index(Request $request){
        try {
            
            $paginate = $request->paginate ?? 10;

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

        return $this->makeResponseSuccessful(@trans('core::messages.created_successfully'));
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
            return response()->json(['error' => true,'message' => $e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->makeResponseSuccessful(@trans('core::messages.updated_successfully'));
    }

    public function destroy(Role $role)
    {
        try {
            
            $role->syncPermissions([]);
            $role->delete();

        } catch (\Exception $e) {
            return response()->json(['error' => true,'message' => $e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);   
        }

        return $this->makeResponseSuccessful(@trans('core::messages.deleted_successfully'));
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
            return response()->json(['error' => true,'message' => $e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);    
        }
        
        return response()->json(['error' => false,'message' => @trans('core::messages.assign_role_to_user_successfully')],JsonResponse::HTTP_OK);

    }

    public function assignPermissionToRole(Role $role, Request $request)
    {
        try {

            $role->syncPermissions($request->permissions);

        } catch (\Exception $e) {
            return response()->json(['error' => true,'message' => $e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);   
        }
        
        return response()->json(['error' => false,'message' => @trans('core::messages.assign_permission_to_role_successfully')],JsonResponse::HTTP_OK);   
    }

    public function clearCache()
    {
        try {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();   
        } catch (\Exception $e) {
            return response()->json(['error' => true,'message' => $e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);   
        }

        return response()->json(['error' => false,'message' => @trans('core::messages.clear_cache_successfully')],JsonResponse::HTTP_OK);
    }


}
