<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roles extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $fillable = [
        "name",
    ];

    public function users() {
        return $this->belongsToMany('App\Models\User', 'role_user', 'user_id', 'role_id');
    }
}
