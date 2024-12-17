<?php
namespace App\Http\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Core\Repositories\Interfaces\SettingInterFace;
use Cache;

class SettingRepository extends RepositoriesAbstract implements SettingInterFace
{
	public function loadSettingData(array $keys = [],string $type = "dashboard") {

        if (!empty($keys)) {
            $data = $this->model->whereIn('key',$keys)->get();            
        }else{
            $data = $this->all();                
        }

        return $data;
	}
}
