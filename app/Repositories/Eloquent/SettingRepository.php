<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\RepositoriesAbstract;
use App\Repositories\Interfaces\SettingInterFace;

class SettingRepository extends RepositoriesAbstract implements SettingInterFace
{
	public function loadSettingData(array $keys = [],string $type = "dashboard") {

        if (!empty($keys)) {
            $data = $this->model->whereIn('key',$keys)->pluck('value','key');            
        }else{
            $data = $this->model->pluck('value','key');                
        }

        return $data;
	}
}
