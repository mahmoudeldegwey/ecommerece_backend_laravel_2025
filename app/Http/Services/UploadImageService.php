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

            $url = $this->uploadImage($file,$destination);

            $data = [
                "name" => $name,
                "extension" => $extension,
                "model_id" => $request->model_id,
                "model_type" => $this->getModelType($request->model_type),
                "url" => $url
            ];
        
            $image = Image::create($data);
            
        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful(['url' =>  $url,'id' =>  $image->id]);

    }

    public function destroy(Image $image, Request $request)
    {
        try {
            
            $this->removeImage($request->destination, $image->name, $image->extension);
            
            $image->delete();
        

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }
    }

    protected function getModelType($model_type){
        return match ($model_type) {
            "product" => "App\Models\Product",
            default => null,
        };
    }

}
