<?php
namespace App\Http\Controllers\Website;

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
        $request['type'] = "frontend";
        
        return $this->settingService->index($request);
    }
    
}
