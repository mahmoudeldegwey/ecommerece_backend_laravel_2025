<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\ProductReview;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductReviewResource;
use App\Filters\ProductReview\{StatusFilter,ProductIDFilter};
use Illuminate\Pipeline\Pipeline;
use DB;
use Auth;

class ProductReviewController extends Controller
{
    public function index(Request $request){
    	
    	try {

            $query = ProductReview::query()->with(['product']);

            $data =  app(Pipeline::class)
                ->send($query)
                ->through([
                    StatusFilter::class,
                ])
                ->thenReturn()
                ->orderBy('id','DESC')
                ->paginate($request->get('paginate',10));

    	} catch (\Exception $e) {
    		return $this->makeResponseErrors($e->getMessage());
    	}
        
        return ProductReviewResource::collection($data);
    }


    public function approveReview(ProductReview $product_review){
        try {

            $product_review->status = 'active';
            $product_review->save();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();
    }

    public function destroy(ProductReview $product_review){
        try {
            
            $product_review->delete();

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return $this->makeResponseSuccessful();

    }

}
