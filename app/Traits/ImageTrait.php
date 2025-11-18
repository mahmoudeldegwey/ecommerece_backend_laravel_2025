<?php
namespace App\Traits;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use File;

trait ImageTrait
{
    public function uploadImage($image, string $destination = "", ?string $extention = "webp" ){
        
        $name = $this->getImageName($image).".$extention";


        if (!file_exists(public_path($destination))) {
            File::makeDirectory(public_path($destination));  
        }

        $image = Image::read($image)->toWebp()->save(public_path("$destination/$name"));

        $url = asset("$destination/$name");
        
        return $url;

    }

    public function saveImage(array $data = []){

    }

    public function getImageName($image){
        return str_replace(' ', '-', File::name($image->getClientOriginalName()))."-".microtime(true);
    }

    public function removeImage(string $folder = "" ,string $image_name = ""){
        return File::delete("$folder/$image_name");
    }
}
