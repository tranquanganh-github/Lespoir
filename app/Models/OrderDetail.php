<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_detail";
    protected $fillable = [
        "order_id",
        "product_id",
        "quantity",
        "price",
        "status"
    ];
    public $timestamps= true;
    use HasFactory;
    public function order()
    {
        return $this->hasOne(Orders::class,"order_id");
    }
    public function product()
    {
        return $this->hasOne(Products::class,"product_id");
    }
}
