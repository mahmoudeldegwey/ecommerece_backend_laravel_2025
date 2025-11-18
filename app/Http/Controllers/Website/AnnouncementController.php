<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Http\Resources\AnnouncementResource;
use Illuminate\Pipeline\Pipeline;

class AnnouncementController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Announcement::query()->isActive() ->orderBy('id','DESC')
        ->limit(2)
        ->get();

        return AnnouncementResource::collection($data);
    }
    
}