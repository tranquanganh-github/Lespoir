<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Laravel\Scout\Searchable;


/**
 * @method static select()
 * @method static find(mixed $id)
 */
class News extends Model
{
    use HasFactory,Searchable;

    protected $news = "news";
    public $timestamps = true;
    protected $fillable = [
        "title",
        "description",
        "author_id",
        "content",
        "thumbnail",
        "status",
        "created_at",
        "updated_at",
    ];

    public function user()
    {
        return $this->hasOne(User::class,"id","author_id");
    }
    public function statusString()
    {
        return match ($this->status) {
            1 => "Active",
            0 => "Delete",
            default => "Unknown",
        };
        return "1";
    }
    public function searchableAs()
    {
        return 'news_index';
    }

//    protected function makeAllSearchableUsing(Builder $query): Builder
//    {
//        return $query->with('user');
//    }

    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' =>  $this->description,
        ];
    }
}
