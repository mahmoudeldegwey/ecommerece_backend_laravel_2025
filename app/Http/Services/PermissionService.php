<?php 
namespace App\Http\Services;

use App\Repositories\Interfaces\PermissionInterFace;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{Permission};
use App\Http\Resources\PermissionResource;
use Permission as PermissionFacad;
use App\Traits\ResponsesTrait;

class PermissionService {
    
    use ResponsesTrait;

    public function __construct(private PermissionInterFace $permissionInterFace)
    {

    }

    public function index(Request $request){
        
        try {
            
            $paginate = $request->paginate ?? 20;
            $guard = $request->guard;

            $model = $this->permissionInterFace->getModel()->where('guard_name',$guard);

            $data = $model->paginate($paginate);

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return PermissionResource::collection($data);
    }

    public function store(Request $request){
        try{
            
            if ($request->guard == "admin") {
                $permissions = PermissionFacad::getListDashboardRoutesName();
            }else if($request->guard == "customer"){
                $permissions = PermissionFacad::getListPortalRoutesName();
            }

            $data = [];

            foreach($permissions as $key => $permission){
                
                $checkExist = $this->permissionInterFace->getFirstBy(['name' => $permission['value'], 'guard_name' => $request->guard]);
                
                if ($checkExist) continue;
                
                $data[] = [
                    'model' => $permission['model'],
                    'name' => $permission['value'],
                    'value' => $permission['name'],
                    'guard_name' => $request->guard
                ];
            }

            $this->permissionInterFace->insert($data);

        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function show(){
        try {
        
        
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try{
            


        }catch(\Exception $e){
            return $this->makeResponseErrors($e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());   
        }
        
        return $this->makeResponseSuccessful();
    }

}
