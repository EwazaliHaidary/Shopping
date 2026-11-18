<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with("category")->get();

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
