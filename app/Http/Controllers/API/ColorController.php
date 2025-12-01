<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Http\Resources\ColorResource;
use App\Http\Requests\ColorRequest;
use Illuminate\Pipeline\Pipeline;
use App\Filters\Color\NameFilter;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Color::query();
        
        $data = app(Pipeline::class)
        ->send($query)
        ->through([
            NameFilter::class,
        ])->thenReturn()
        ->orderBy('id','DESC')
        ->paginate($request->get('paginate',20));

        return ColorResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        try {
            
            Color::create($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return new ColorResource($color);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, Color $color)
    {
        try {
            
            Color::where('id',$color->id)->update($request->validated());

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return $this->makeResponseSuccessful();
    }

    /**
     * search
     */
    public function search(Request $request)
    {
        $data = Color::query()
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

        return ColorResource::collection($data);
    }

}
