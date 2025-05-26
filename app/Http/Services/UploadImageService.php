<?php 
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\{ResponsesTrait,ImageTrait};
use App\Models\Image;

class UploadImageService {

    use ResponsesTrait, ImageTrait;

    public function __construct()
    {

    }

    public function store(Request $request)
    {
        try {
            
            $file = $request->file('file');
            $destination = $request->destination;
            $extension = "webp";
            $name = $this->getImageName($file);

            $data = [
                "name" => $name,
                "extension" => $extension,
                "model_id" => $request->model_id,
                "model_type" => $this->getModelType($request->model_type),
                "url" => asset("$destination/$name.$extension")
            ];
        
            $image = Image::create($data);
            
            if ($image) {
                $this->uploadImage($file,$destination);
            }

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();

    }

    protected function getModelType($model_type){
        return match ($model_type) {
            "product" => "App\Models\Product",
            default => null,
        };
    }

}
