<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = "orders";
    public $timestamps = true;
    protected $fillable = [
        "user_id",
        "total_price",
        "shipping_price",
        "address",
        "code",
        "cart_id",
        "status"
    ];

    public function order_details(){
        return $this->hasMany(OrderDetail::class,"order_id","id");
    }

    public function user()
    {
        return $this->hasOne(User::class,"user_id");
    }
}
