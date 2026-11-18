<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "category_id" => $this->category_id,
            "name" => $this->name,
            "sku" => $this->sku,
            "description" => $this->description,
            "purchase_price" => $this->purchase_price,
            "sale_price" => $this->sale_price,
            "stock" => $this->stock,
            "alert_quantity" => $this->alert_quantity,
            "is_active" => $this->is_active,

            "category" => $this->whenLoaded("category", function () {
                return $this->category->name;
            }),
        ];
    }
}
