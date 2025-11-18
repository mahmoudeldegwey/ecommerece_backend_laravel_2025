<?php
namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\{ProductReview};
use App\Http\Requests\ProductReviewRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductReviewResource;
use App\Traits\ImageTrait;
use DB;
use Auth;

class ProductReviewController extends Controller
{
    use ImageTrait;

    public function index(Request $request, $product_id){
        try {

            $data = ProductReview::query()->where(['product_id' => $product_id,'status' => 'active'])
                ->orderBy('id','DESC')
                ->paginate($request->get('paginate',10));

        } catch (\Exception $e) {
            return response()->json(["error" => true , "message" => $e->getMessage()] , JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return ProductReviewResource::collection($data);

    }

    public function store(ProductReviewRequest $request,$product_id){
    	try {

            $data = $request->validated();

            if($request->file('image')){
                $data['image'] = $this->uploadImage($request->file('image'),"products-reviews");
            }
    		
            ProductReview::create([
                'product_id' => $product_id,
                'username' => $data['username'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'image' => $data['image'],
                'rate' => $data['rate'],
                'message' => $data['message']
            ]);

    	} catch (\Exception $e) {
    		return response()->json(["error" => true , "message" => $e->getMessage()] , JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    	}
        return $this->makeResponseSuccessful();
    }
}
