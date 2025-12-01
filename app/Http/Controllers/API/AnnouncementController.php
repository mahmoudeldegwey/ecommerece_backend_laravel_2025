<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Http\Resources\AnnouncementResource;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use App\Filters\Announcements\{NameFilter,StatusFilter};

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Announcement::query();

        $data = app(Pipeline::class)
        ->send($query)
        ->through([
            NameFilter::class,
            StatusFilter::class
        ])->thenReturn()
        ->orderBy('id','DESC')
        ->paginate($request->get('paginate',20));

        return AnnouncementResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request)
    {
        try {
            
            Announcement::create($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return new AnnouncementResource($announcement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        try {
            
            Announcement::where('id',$announcement->id)->update($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        try {
            
            $announcement->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->makeResponseSuccessful();
    }

}
