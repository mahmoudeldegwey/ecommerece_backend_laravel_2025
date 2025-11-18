<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Http\Resources\SizeResource;
use App\Http\Requests\SizeRequest;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Size::orderBy('id','DESC')->paginate($request->get('paginate',20));

        return SizeResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        try {
            
            Size::create($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return new SizeResource($size);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, Size $size)
    {
        try {
            
            Size::where('id',$size->id)->update($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return $this->makeResponseSuccessful();
    }

    /**
     * search
     */
    public function search(Request $request)
    {
        $data = Size::query()
        ->when($request->filled('search_value') ,function($query) use ($request) {
            $search_value = $request->search_value;
            $query->where(function ($query) use ($search_value) {
            // convert array to string to search by LIKE
                $query->orWhere('name', 'LIKE', $search_value)
                    ->orWhere('name_ar', 'LIKE', $search_value);
                
            });
        })
        ->select('id','name','name_ar','image')
        ->get();

        return SizeResource::collection($data);
    }

}
