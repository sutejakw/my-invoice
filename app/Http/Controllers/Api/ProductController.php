<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Get all product.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $resource = Product::orderBy('id', 'DESC')->get();
            $products = ProductResource::collection($resource);

            return ResponseFormatter::success($products);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
