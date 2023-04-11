<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ShoppingCart extends Model
{
    use HasFactory;
    protected $table="shopping_carts";
    public $timestamps = true;
    protected $fillable = [
        "user_id",
        "status",
    ];
    public function user()
    {
        return $this->hasOne('App\Models\User',"user_id");
    }
    public function items(){
        return $this->hasMany(CartItem::class,"cart_id","id");
    }
}
