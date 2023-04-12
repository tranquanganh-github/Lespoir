<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $paragraphs = fake()->paragraphs(rand(6, 10));
        $descriptions = fake()->paragraphs(rand(1, 2));
        $img = [
            "https://bizweb.dktcdn.net/thumb/large/100/393/641/articles/6-1.jpg?v=1676019742413",
            "https://bizweb.dktcdn.net/thumb/large/100/393/641/articles/thiep-gs-jpg-7.jpg?v=1671440173170",
            "https://bizweb.dktcdn.net/thumb/large/100/393/641/articles/z3981705980097-687070192837e14acb0c1cdad1e19855.jpg?v=1672045423233",
            "https://bizweb.dktcdn.net/thumb/large/100/393/641/articles/overnight-oats-3.jpg?v=1669884092487",
            "https://bizweb.dktcdn.net/thumb/large/100/393/641/articles/giai-phap-qua-tang-tet-2023-cho-doanh-nghiep.png?v=1667792854877",
        ];
        $post = "";
        $description = "";
        foreach ($paragraphs as $para) {
            $post .= "<p> {$para} </p>";
        }
        foreach ($descriptions as $para) {
            $description .= " {$para} ";
        }
        return [
            "title" => fake()->name(),
            "description" => $description,
            "author_id" => rand(1,2),
            "content" => $post,
            "thumbnail" => $img[rand(0,4)],
            "status" => 1,
            "created_at" => Carbon::now(),
        ];
    }
}
