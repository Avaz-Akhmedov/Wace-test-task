<?php

namespace App\Http\Controllers;


use App\Http\Requests\Product\GenerateProductEstimateRequest;
use App\Http\Requests\Product\SearchProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{

    public function search(SearchProductRequest $request): ResourceCollection
    {

        $searchQuery = $request->validated('query');

        $products = Product::query()
            ->latest()
            ->whereRaw('MATCH(name, description) AGAINST(? IN NATURAL LANGUAGE MODE)', [$searchQuery])
            ->paginate(16);

        return ProductResource::collection($products);
    }

    public function generateProductEstimate(GenerateProductEstimateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $totalCost = collect($validatedData['products'])->reduce(function ($carry, $product) {
            return $carry + $product['quantity'] * Product::query()->find($product['id'])->price;
        }, 0);

        if (isset($validatedData['installation_cost'])) {
            $totalCost += $validatedData['installation_cost'];
        }

        return response()->json([
            'total_cost' => $totalCost,
        ]);
    }
}
