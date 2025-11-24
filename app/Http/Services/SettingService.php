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
                $data = $this->settingInterFace->loadSettingData([
                    'website_name','website_description','website_description_ar','email','facebook','twitter',
                    'instagram','youtube','phone_number','copyrights','copyrights_ar','website_name_ar','default_language','default_currency','default_country','website_logo'],'frontend');                
            }else if($request->type == "dashboard"){
                $data = $this->settingInterFace->loadSettingData();
            }

        } catch (\Exception $e) {
           return $this->makeResponseErrors($e->getMessage());
        }

        return $data;

        return SettingResource::collection($data);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->settings;
            $settingsData = $this->settingInterFace->loadSettingData()->toArray();
            $insertData = [];

            foreach($data as $key => $value){
                $keyExist = array_key_exists($value['key'], $settingsData);
                
                if ($keyExist) {
                    $this->settingInterFace->update(['key' => $value['key']],['value' => $value['value']]);
                    continue;
                }  

                $insertData[] = ['key' => $value['key'],'value' => $value['value']];
            }

            $this->settingInterFace->insert($insertData);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();

    }

}
