<?php 
namespace App\Http\Services;

use App\Repositories\Interfaces\SettingInterFace;
use App\Http\Resources\SettingResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponsesTrait;
use Cache;

class SettingService {

    use ResponsesTrait;

    public function __construct(private SettingInterFace $settingInterFace)
    {

    }

    public function index(Request $request)
    {
        try {
            
            if ($request->type == "frontend") {
                $data = $this->settingInterFace->loadSettingData(['email','company','phone','facebook','twitter','instagram','youtube','linkedin','site_key'],'frontend');                
            }else if($request->type == "dashboard"){
                $data = $this->settingInterFace->loadSettingData();
            }

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return SettingResource::collection($data);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $settingsData = $this->settingInterFace->loadSettingData()->pluck('value','key')->toArray();
            $insertData = [];

            foreach($data as $key => $value){
                $keyExist = array_key_exists($key, $settingsData);
                
                if ($keyExist) {
                    $this->settingInterFace->update(['key' => $key],['value' => $value]);
                    continue;
                }  

                $insertData[] = ['key' => $key,'value' => $value];
            }

            $this->settingInterFace->insert($insertData);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return response()->json(['error' => false,'message' => 'Successfully update'],JsonResponse::HTTP_OK);

    }

}
