<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    public $timestamps = true;
    protected $fillable = [
        "thumbnail",
        "name",
        "quantity",
        "price",
        "status",
    ];

    public function order_details(){
        return $this->hasMany(OrderDetail::class,"order_id","id");
    }
    public function cart_items(){
        return $this->hasMany(CartItem::class,"cart_id","id");
    }
}
