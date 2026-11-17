<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;

class SaleItemController extends Controller
{
    // Display all sale items
    public function index()
    {
        return SaleItem::with(["product", "sale"])->get();
    }

    // Display one sale item
    public function show(string $id)
    {
        $saleItem = SaleItem::with(["product", "sale"])
            ->findOrFail($id);

        return response()->json([
            "data" => $saleItem
        ]);
    }
}
