<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleItemResource;
use App\Models\SaleItem;
use Illuminate\Cache\Events\RetrievingKey;

class SaleItemController extends Controller
{
    // Display all sale items
    public function index()
    {
        $sale = SaleItem::with(["product", "sale"])->get();
        return SaleItemResource::collection($sale);

    }

    // Display one sale item
    public function show(string $id)
    {
        $saleItem = SaleItem::with(["product", "sale"])
            ->findOrFail($id);

        return new SaleItemResource($saleItem);
    }
}
