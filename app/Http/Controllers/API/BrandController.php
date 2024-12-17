<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Resources\BrandResource;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Brand::orderBy('id','DESC')->paginate($request->get('paginate',20));

        return BrandResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            
            Brand::create($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            
            Brand::where('id',$brand->id)->update($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->destroy();

        return $this->makeResponseSuccessful();
    }

    /**
     * search
     */
    public function search(Request $request)
    {
        $data = Brand::query()
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

        return BrandResource::collection($data);
    }

}
