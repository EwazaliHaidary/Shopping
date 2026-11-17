<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("categories", CategoryController::class);
Route::apiResource("products", ProductController::class);
Route::apiResource("customers", CustomerController::class);
Route::apiResource("sales", SaleController::class );
Route::get("/saleItems", [SaleItemController::class, "index"]);
Route::get("/saleItems/{id}", [SaleItemController::class, "show"]);