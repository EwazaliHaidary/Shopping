<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "category_id" => $this->id,
            "name" => $this->name,
            "sku" => $this->sku,
            "description" => $this->description,
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
