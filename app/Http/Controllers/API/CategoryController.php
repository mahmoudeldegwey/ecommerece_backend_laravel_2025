<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Category::orderBy('id','DESC')->paginate($request->get('paginate',20));

        return CategoryResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            
            Category::create($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            
            Category::where('id',$category->id)->update($request->validated());

        } catch (\Exception $e) {
            return makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->destroy();

        return $this->makeResponseSuccessful();
    }

    /**
     * search
     */
    public function search(Request $request)
    {
        $data = Category::query()
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

        return CategoryResource::collection($data);
    }

}
