<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "sale_id" => $this->sale_id,
            "product_id" => $this->product_id,
            "quantity" => $this->quantity,
            "unit_price" => $this->unit_price,
            "subtotal" => $this->subtotal,

            "product" => $this->whenLoaded("product", function () {
                return [
                    "id" => $this->product->id,
                    "name" => $this->product->name,
                    "sku" => $this->product->sku,
                ];
            }),
        ];
    }
}
