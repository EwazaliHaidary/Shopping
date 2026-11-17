<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "user_id" =>$this->user_id,
            "customer_id" =>$this->customer_id,
            "total_price" =>$this->total_price,
            "discount" => $this->discount,
            "final_price" =>$this->final_price,
            "status" =>$this->status,
            "notes" =>$this->notes,
            "customer" => $this->whenLoaded("customer", function(){
                return $this->customer->name;
            }),
            "user" => $this->whenLoaded("user", function(){
                return $this->user->name;
            })

        ];
    }
}
