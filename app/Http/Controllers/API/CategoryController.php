<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryRequest;
use App\Traits\ImageTrait;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ImageTrait;

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
            
            $data = $request->validated();

            if($request->file('image')){
                $data['image'] = $this->uploadImage($request->file('image'),"categories");
            }
            
            Category::create($data);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
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
    public function update(Category $category,CategoryRequest $request)
    {
        try {
            
            $data = $request->validated();

            if($request->file('image')){
                $data['image'] = $this->uploadImage($request->file('image'),"categories");
            }
            
            Category::where('id',$category->id)->update($data);

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->makeResponseSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            
            $category->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage(),'Errors',JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        
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
