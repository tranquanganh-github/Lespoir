<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = "cart_items";
    public $timestamps= true;
    protected $fillable = [
        "product_id",
        "cart_id",
        "quantity",
        "unit_price",
        "status",
    ];
    use HasFactory;
    public function cart()
    {
        return $this->hasOne(ShoppingCart::class,"cart_id");
    }
    public function product()
    {
        return $this->hasOne(Products::class,"product_id");
    }
}
