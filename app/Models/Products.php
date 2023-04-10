<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $products = "products";
    public $timestamps = true;
    protected $fillable = [
        "thumbnail",
        "name",
        "quantity",
        "price",
        "status",
        "created_at",
        "updated_at"
    ];

    public function order_details(){
        return $this->hasMany(OrderDetail::class,"order_id","id");
    }
    public function cart_items(){
        return $this->hasMany(CartItem::class,"cart_id","id");
    }
    public function  statusString(){
        switch ($this->status){
            case 1:
                return "Active";
            case 0:
                return "Delete";

        }
    }
}
