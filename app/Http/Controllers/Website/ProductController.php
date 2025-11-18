<?php
namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pipeline\Pipeline;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
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
}
