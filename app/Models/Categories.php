<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $products = "categories";
    public $timestamps = true;
    protected $fillable = [
        "name",
        "status",
    ];
    public function products(){
        return $this->hasMany(Products::class,"category_id","id");
    }
    public function  statusString(){
        switch ($this->status){
            case 1:
                return "Active";
            case 0:
                return "Delete";
            default:
                return "Unknown";
        }
    }
}
