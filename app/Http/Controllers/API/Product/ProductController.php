<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\API\PaginatedResourceCollection;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('active', true)->with(['category','attachments'])->latest()
            ->paginate(10);
        return apiSuccess(new PaginatedResourceCollection($products, ProductResource::class));

        return apiSuccess(ProductResource::collection($products));
    }

    public function show(Product $product)
    {
        return apiSuccess(new ProductResource($product->load('sizes','attachments')));
    }
}
