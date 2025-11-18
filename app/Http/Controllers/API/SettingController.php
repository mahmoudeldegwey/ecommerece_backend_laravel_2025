<?php
namespace App\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Services\SettingService;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    public function __construct(private SettingService $settingService)
    {
    }

    public function index(Request $request)
    {
        $request['type'] = "dashboard";
        
        return $this->settingService->index($request);
    }

    public function store(SettingRequest $request)
    {
        //return $request->all();

        return $this->settingService->store($request);
    }
    
}
