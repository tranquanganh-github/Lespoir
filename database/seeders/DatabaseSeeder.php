<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->insert([
            [
                'id'=>1,
                'name'=>'Strawberry',
                'price'=>85,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-1.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>2,
                'name'=>'Berry',
                'price'=>70,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-2.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>3,
                'name'=>'Lemon',
                'price'=>35,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-3.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>4,
                'name'=>'Avocado',
                'price'=>50,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-4.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>5,
                'name'=>'Green Apple',
                'price'=>45,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-5.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>6,
                'name'=>'Strawberry',
                'price'=>80,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-6.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>10,
                'name'=>'Mango',
                'price'=>60,
                'thumbnail'=>'https://traicay141.vn/upload/sanpham/0fe3cdf92bc94d6497c82b4c3750343e_3661491349594ea6b88a67cf0677ba64_master8315_154x200.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>8,
                'name'=>'Grapefruit',
                'price'=>100,
                'thumbnail'=>'https://traicay141.vn/upload/sanpham/buoi-da-xanh5384_270x180.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>9,
                'name'=>'Mangosteen',
                'price'=>80,
                'thumbnail'=>'https://traicay141.vn/upload/sanpham/mangosteen_4_8f179079a350431685c5144d1d54adc4_e80ab65f7a124f01bd1862f023cbfd1b_master4506_257x200.jpg',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>7,
                'name'=>'Apple',
                'price'=>80,
                'thumbnail'=>'https://cdn.pixabay.com/photo/2018/05/08/21/28/apple-3384010__340.png',
                'quantity'=>100,
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
        ]);
        DB::table('roles')->insert([
            [
                'id'=>1,
                'name'=>'Admin',
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>2,
                'name'=>'User',
                'created_at'=>Carbon::now(),
            ],
        ]);
        DB::table('role_user')->insert([
            [
                'id'=>1,
                'user_id'=>1,
                'role_id'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>2,
                'user_id'=>2,
                'role_id'=>2,
                'created_at'=>Carbon::now(),
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
