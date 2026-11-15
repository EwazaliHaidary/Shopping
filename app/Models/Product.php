<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\SaleItem;


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

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function saleItem(){
        return $this->hasMany(SaleItem::class);
    }

}
