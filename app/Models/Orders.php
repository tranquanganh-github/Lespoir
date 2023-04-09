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
        "name",
        "email",
        "status",
        "message",
    ];

    public function order_details(){
        return $this->hasMany(OrderDetail::class,"order_id","id");
    }

    public function user()
    {
        return $this->hasOne(User::class,"user_id");
    }

    public function  statusString(){
        switch ($this->status){
            case 1:
                return "Paid";
            case 0:
                return "Delete";
            case 4:
                return "Waiting";
            default:
                return "Unknown";
        }
    }
}
