<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
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
}
