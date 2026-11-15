<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Product;

class SaleItem extends Model
{
    protected $fillable = [
        "product_id",
        "sale_id",
        "quantity",
        "unit_price",
        "subtotal"
    ];

    public function product(){
        return $this->belongsTo(Product::class);

    }
    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}
