<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        "category_id",
        "name",
        "sku",
        "description",
        "purchase_price",
        "sale_price",
        "stock",
        "alert_quantity",
        "is_active"
    ];
}
