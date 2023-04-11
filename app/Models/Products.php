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
        "updated_at",
        "description",
        "category_id",
    ];

    public function category()
    {
        return $this->hasOne(Categories::class, "id", "category_id");
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id");
    }

    public function cart_items()
    {
        return $this->hasMany(CartItem::class, "cart_id", "id");
    }

    public function statusString()
    {
        switch ($this->status) {
            case 1:
                return "Active";
            case 0:
                return "Delete";
            default:
                return "Unknown";
        }
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrice($query, $request)
    {
        if ($request->has("min") &&
            $request->has("max") &&
            !is_null($request->min) &&
            !is_null($request->max)) {
            $query->where("price", ">=", $request->min)
                ->where("price", "<=", $request->max);
        }
        return $query;
    }
    public function scopeKeyword($query,$request){
        if ($request->has("search") && !is_null($request->search)){
            $keyword = $request->search;
            $size = 10;
            $query->where(function ($query) use($keyword,$size){
                $query->where("name","like","%$keyword%");
                $query = is_numeric($keyword) ? $query->orwhere(function ($query) use ($keyword,$size){
                    return $query->where("price","<",$keyword + $size)->where("price",">",($keyword > $size ? $keyword-$size:$keyword));
                }) : $query;
                return$query;
            });
        }
        return $query;
    }
    public function scopeCategory($query,$request){
        if ($request->has("category_id") && !is_null($request->category_id)){
            $category_id = $request->category_id;
            $query->where("category_id","=",$category_id);
        }
        return $query;
    }
}
