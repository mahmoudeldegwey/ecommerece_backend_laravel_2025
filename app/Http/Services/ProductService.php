<?php 
namespace App\Http\Services;

use App\Repositories\Interfaces\{ProductInterFace};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use App\Models\Product;
use App\Traits\ResponsesTrait;
use App\Filters\Products\{ProductNameFilter,PriceRangeFilter,BrandIDFilter,CategoryIDFilter,OrderByFilter, SkuFilter};
use App\Http\Resources\ProductResource;
use App\Traits\ImageTrait;
use DB;

class ProductService {

    use ResponsesTrait,ImageTrait;

    // Cache key for the product list
    protected $cacheKey = 'products_list';

    public function __construct(
        private ProductInterFace $productInterFace
    )
    {

    }

    public function index(Request $request) {
        try {

            $query = $this->productInterFace->getModel()->select('products.*')
            ->with(['images','brand','categories','colors','sizes']);

            $data =  app(Pipeline::class)
                ->send($query)
                ->through([
                    ProductNameFilter::class,
                    PriceRangeFilter::class,
                    BrandIDFilter::class,
                    CategoryIDFilter::class,
                    OrderByFilter::class,
                    SkuFilter::class,
                ])
                ->thenReturn()
                ->orderBy('id',$request->get('order_by','DESC'))
                ->paginate($request->get('paginate',20));

        } catch (\Exception $e) {
            return $this->makeResponseErrors($e->getMessage());
        }

        return ProductResource::collection($data);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{

            $sku = is_null($request->sku) ? get_unique_id(7,'num') : $request->sku;

            $request['sku'] = $sku;
            $data = $request->except(['categories','colors','sizes','main_image']);
            
            $data['main_image'] = $this->uploadImage($request->file('main_image'),"products");

            $product = $this->productInterFace->getModel()->create($data);
            
            $product->categories()->sync($request->categories);
    
            if (isset($request->colors) and !empty($request->colors)) {
                $product->colors()->sync($this->handleColors($request->colors));                
            }

            if (isset($request->sizes) and !empty($request->sizes)) {
                $product->sizes()->sync($this->handleSizes($request->sizes));               
            }

        }catch(\Exception $e){
            DB::rollBack();
            return $this->makeResponseErrors($e->getMessage());
        }

        DB::commit();

        return $this->makeResponseSuccessful();
    }

    public function show(Product $product){
        $product = $this->productInterFace->getModel()->where('id',$product->id)
            ->select('products.*')
            ->with(['images','brand','categories','colors','sizes'])->first();

        return new ProductResource($product);
    }

    public function update(Product $product,Request $request)
    {
        DB::beginTransaction();
        try {
            
            $data = $request->except(['categories','colors','sizes','main_image']);            
            $data['main_image']= $this->uploadImage($request->file('main_image'),"products");

            $product->update($data);

            $product->categories()->sync($request->categories);
    
            if (isset($request->colors) and !empty($request->colors)) {
                $product->colors()->sync($this->handleColors($request->colors));                
            }

            if (isset($request->sizes) and !empty($request->sizes)) {
                $product->sizes()->sync($this->handleSizes($request->sizes));               
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return $this->makeResponseErrors($e->getMessage());
        }

        DB::commit();

        return $this->makeResponseSuccessful();
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            

            $product->colors()->sync([]);
            $product->sizes()->sync([]);
            $product->categories()->sync([]);
            $product->images()->delete();

            $product->delete();

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->makeResponseErrors($e->getMessage());
        }
        DB::commit();
        return $this->makeResponseSuccessful();
    }

    protected function handleColors($colors){
        return collect($colors)
        ->mapWithKeys(function ($color) {
            return [
                $color['color_id'] => [
                    'price' => $color['price'] ?? null,
                    'image' => $color['image'] ?? null,
                    'value' => $color['value'] ?? null
                ]
            ];
        })
        ->toArray();
    }

    protected function handleSizes($sizes){
        return collect($sizes)
        ->mapWithKeys(function ($size) {
            return [
                $size['size_id'] => [
                    'price' => $size['price'] ?? null,
                    'image' => $size['image'] ?? null,
                ]
            ];
        })
        ->toArray();
    }

}
