<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleItemResource;
use App\Models\SaleItem;

class SaleItemController extends Controller
{
    // Display all sale items
    public function index()
    {
        $saleItems = SaleItem::with([
            "product",
            "sale"
        ])->get();

        return SaleItemResource::collection($saleItems);
    }

    // Display one sale item
    public function show(string $id)
    {
        $saleItem = SaleItem::with([
            "product",
            "sale"
        ])->findOrFail($id);

        return new SaleItemResource($saleItem);
    }
}
