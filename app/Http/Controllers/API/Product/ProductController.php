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
        $category_id = $request->input('category_id');
        $search = $request->input('search');
        $limit = $request->input('limit', 10);
        $productsQuery = Product::where('active', true)->with(['category', 'attachments']);
        if (isset($category_id)) {
            $productsQuery->where('category_id', $category_id);
        }
        if (isset($search)) {
            $productsQuery->search($search);
        }
        $products = $productsQuery->latest()->paginate($limit);
        return apiSuccess(new PaginatedResourceCollection($products, ProductResource::class));

        // return apiSuccess(ProductResource::collection($products));
    }

    public function show(Product $product)
    {
        return apiSuccess(new ProductResource($product->load('sizes', 'attachments')));
    }
}
