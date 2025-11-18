<?php
namespace App\Http\Controllers\Website;

use App\Filters\Categories\{IsHomeFilter,IsMenuFilter,CategoryIDFilter};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Pipeline\Pipeline;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        $data =  app(Pipeline::class)
        ->send($query)
        ->through([
            IsHomeFilter::class,
            IsMenuFilter::class,
            CategoryIDFilter::class
        ])
        ->thenReturn()
        ->orderBy('id','DESC')

        ->paginate($request->get('paginate',20));

        return CategoryResource::collection($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
    
}