<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Http\Resources\ProductAttributeResource;
use App\Http\Requests\ProductAttributeRequest;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProductAttribute::orderBy('id','DESC')->paginate($request->get('paginate',20));

        return ProductAttributeResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $request)
    {
        try {
            
            ProductAttribute::create($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAttribute $productAttribute)
    {
        return new ProductAttributeResource($productAttribute);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeRequest $request, ProductAttribute $productAttribute)
    {
        try {
            
            ProductAttribute::where('id',$productAttribute->id)->update($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->destroy();

        return $this->makeResponseSuccessful();
    }

    /**
     * search
     */
    public function search(Request $request)
    {
        $data = productAttribute::query()
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

        return ProductAttributeResource::collection($data);
    }

}
