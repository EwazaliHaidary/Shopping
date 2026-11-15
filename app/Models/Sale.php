<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Customer;
use App\Models\SaleItem;
class Sale extends Model
{
    protected $fillable = [
            "user_id",
            "customer_id",
            "quantity",
            "total_price",
            "discount",
            "final_price",
            "status",
            "notes"

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function sales_items(){
        return $this->hasMany(SaleItem::class);
    }
}
