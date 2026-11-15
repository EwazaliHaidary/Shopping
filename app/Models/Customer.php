<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
class Customer extends Model
{
    protected $fillable =[
        "name",
        "email",
        "phone",
        "address"
    ];


    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
