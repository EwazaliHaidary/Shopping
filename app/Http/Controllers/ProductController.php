<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with("category");

        // Category filtering
        $query->when($request->query('category_id'), function($q, $categoryId){
            $q->where("category_id", $categoryId);
        });

        // filtring by category
         $query->when($request->has('is_active'), function ($q) use ($request) {
             $q->where('is_active', $request->boolean('is_active'));
         });

         // Sorting
    $allowedSorts = [
        'name',
        'sale_price',
        'purchase_price',
        'created_at'
    ];

    $sort = $request->query('sort', 'created_at');
    $direction = $request->query('direction', 'asc');

    if (!in_array($sort, $allowedSorts)) {
        $sort = 'created_at';
    }

    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'asc';
    }

    // Execute query
    $products = $query->orderBy($sort, $direction)->get();

    return ProductResource::collection($products);
}

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        $product->load("category");
        return response()->json([
            "message" => "محصول شما موفقانه ذخیره شد",
            "data" => new ProductResource($product)
        ], 201);
    }

    public function show(string $id)
    {
        $product = Product::with("category")->findOrFail($id);
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validated();

        $product->update($data);

        $product->load("category");

        return response()->json([
            "message" => "ویرایش موفقانه انجام شد",
            "data" => new ProductResource($product)
        ]);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json([
            "message" => "محصول حذف گردید"
        ], 200);
    }
}
