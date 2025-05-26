<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;
use App\Http\Services\UploadImageService;
use App\Traits\ResponsesTrait;

class UploadImageControll extends Controller
{
    public function __construct(public UploadImageService $service){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
        return $this->service->store($request);
    }

}
