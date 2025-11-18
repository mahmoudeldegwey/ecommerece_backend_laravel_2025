<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pipeline\Pipeline;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{ProductRequest,UpdateProductRequest};
use App\Http\Services\ProductService;

class ProductController extends Controller
{


    public function __construct(
        private ProductService $productService
    )
    {

    }

    public function index(Request $request) {
        return $this->productService->index($request);
    }

    public function show(Product $product) : ProductResource {
        return $this->productService->show($product);
    }

    public function store(ProductRequest $request) { 
        return $this->productService->store($request);
    }

    public function update(Product $product, UpdateProductRequest $request) {
        //return $request->all();
       return $this->productService->update($product,$request);
    }

    public function destroy(Product $product) {
        return $this->productService->destroy($product);
    }
}
