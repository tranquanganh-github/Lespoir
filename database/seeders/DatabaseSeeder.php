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
        DB::table('categories')->insert([
            [
                'name'=>'Berry',
                'status'=>'1',
                'created_at'=>Carbon::now(),
            ],
            [
                'name'=>'Nut',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
        ]);
        DB::table('products')->insert([
            [
                'id'=>1,
                'name'=>'Strawberry',
                'price'=>85,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-1.jpg',
                'quantity'=>100,
                'category_id'=>1,
                'description'=>'Improve immune system. Strawberries contain a lot of vitamin C - a substance that helps strengthen the immune system and is an extremely effective antioxidant. Therefore, it can increase resistance, prevent inflammation in our body. In particular, according to the latest research by experts, the antioxidant capacity of strawberries can be effective in just a few weeks. Levels of C-reactive protein (a protein that indicates inflammation in the body) can be reduced by up to 14% after just one week of adding strawberries to the menu!',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>2,
                'name'=>'Grape',
                'price'=>70,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-2.jpg',
                'quantity'=>100,
                'category_id'=>1,
                'description'=> 'Black grapes are full of nutrients and antioxidants. Eating grapes every day can increase the amount of vitamins for the body and prevent other diseases.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>3,
                'name'=>'Lemon',
                'price'=>35,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-3.jpg',
                'quantity'=>100,
                'category_id'=>1,
                'description'=>'The tree is yellow elliptical fruit is used for culinary and non-cooking purposes around the world, primarily for juice, with both cooking and cleaning uses.[2] The pulp and peel are also used in cooking and baking. Lemon juice contains about 5% to 6% citric acid, with a pH of about 2.2, so it has a sour taste. The distinctive sour taste of lemon juice makes it a key ingredient in drinks and foods like lemonade and lemon meringues.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>4,
                'name'=>'Avocado',
                'price'=>50,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-4.jpg',
                'quantity'=>100,
                'category_id'=>2,
                'description'=>'The avocado (Persea americana) is a medium-sized, evergreen tree in the laurel family (Lauraceae). It is native to the Americas and was first domesticated by Mesoamerican tribes more than 5,000 years ago. Then as now it was prized for its large and unusually oily fruit.[3] The tree likely originated in the highlands bridging south-central Mexico and Guatemala.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>5,
                'name'=>'Green Apple',
                'price'=>45,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-5.jpg',
                'quantity'=>100,
                'category_id'=>2,
                'description'=>'The apple, also known as bom (French pronunciation: pomme), is an edible fruit from the apple tree (Malus domestica). Apples are grown around the world and are the most commonly grown tree species in the genus Malus. The apple tree is native to Central Asia, where its ancestor, the Xinjiang wild apple, still exists today. They have been cultivated for thousands of years in Asia and Europe and were brought to North America by European colonists. Apples have religious and mythological significance in many cultures, including Norse, Greek, and Christian Europe.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>6,
                'name'=>'Strawberry',
                'price'=>80,
                'thumbnail'=>'https://themewagon.github.io/fruitkha/assets/img/products/product-img-6.jpg',
                'quantity'=>100,
                'category_id'=>1,
                'description'=>'Strawberry (scientific name: Fragaria × ananassa)[1] is a genus of angiosperms and flowering plants in the Rose family (Rosaceae). Strawberries originated in the Americas and were bred by European gardeners in the 18th century to create the variety of strawberry that is widely grown today. This species was first described by (Weston) Duchesne in 1788. This fruit is appreciated by many people for its characteristic aroma, bright red color, succulent and sweet taste. It is consumed in large quantities, either consumed as fresh strawberries or made into jams, juices, pies, ice cream, milkshakes and chocolates. Artificial strawberry flavorings and ingredients are also widely used in products such as candy, soap, lip gloss, perfume, and many others.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>10,
                'name'=>'Mango',
                'price'=>60,
                'thumbnail'=>'https://traicay141.vn/upload/sanpham/0fe3cdf92bc94d6497c82b4c3750343e_3661491349594ea6b88a67cf0677ba64_master8315_154x200.jpg',
                'quantity'=>100,
                'category_id'=>2,
                'description'=>'Mangosteen (two-part nomenclature: Garcinia mangostana), also known as sweet garlic[1], is a species of tree in the Clusiaceae family. It is also a tropical evergreen tree with edible fruit, native to the island nations of Southeast Asia. Its origin is uncertain due to extensive prehistoric cultivation.[2][3] It grows mainly in Southeast Asia, Southwest India and other tropical areas such as Colombia, Puerto Rico and Florida,[2][4][5] where the tree has been introduced. The tree is 6 to 25 m (19.7 to 82.0 ft) tall.[2] The fruit when ripe has a thick outer skin, dark purple red color, the skin is inedible.[2][4] The flesh is ivory white, succulent, slightly fibrous and divided into many segments, a fruit can contain about 4, 8 packs, very rarely 3 or 9. The fruit has a sweet and sour taste and an attractive aroma. Within each fruit, the edible aromatic flesh surrounding each seed is the vegetative pod, i.e. the inner layer of the ovary.[6][7] The seeds are almond-shaped and small in size.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>8,
                'name'=>'Grapefruit',
                'price'=>100,
                'thumbnail'=>'https://traicay141.vn/upload/sanpham/buoi-da-xanh5384_270x180.jpg',
                'quantity'=>100,
                'category_id'=>1,
                'description'=>'Grapefruit (two-part nomenclature: Citrus maxima (Merr., Burm. f.), or Citrus grandis L., is a citrus fruit, usually pale green to yellow when ripe, with thick citrus, Spongy shrimp, with sweet, bitter or sour taste, depending on the type, pomelos have many sizes depending on the variety, for example, Doan Hung pomelo is only 15 cm in diameter, while Nam Roi pomelo, Tan Trieu pomelo (Bien Hoa), pomelo are only about 15 cm in diameter. green skin (Ben Tre) and many other pomelos commonly found in Vietnam and Thailand with a diameter of about 18–20 cm Some northern provinces also call them pomelos. Pomelo in English is called Pomelo, but many dictionaries. In Vietnam, grapefruit is translated into grapefruit, actually grapefruit is the English name for grapefruit (Citrus paradisi) - a hybrid between grapefruit and orange, with smaller fruit, orange peel, grapefruit smell, pink flesh, sour taste slightly bitter.This mistake led to many other people English mistakes.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>9,
                'name'=>'Mangosteen',
                'price'=>80,
                'thumbnail'=>'https://traicay141.vn/timthumb.php?src=upload/sanpham/artboard-2-copy-3-570x570-8698.png&h=80&w=100&zc=1&q=100',
                'quantity'=>100,
                'category_id'=>1,
                'description'=>'Commercial cherries are obtained from cultivars of several species, such as sweet Prunus avium and sour Prunus cerasus. The name cherry also refers to the tree and its wood, and is sometimes applied to almonds and similar flowering trees in the genus Prunus, as in "ornamental cherry" or "cherry blossom". Wild cherries can refer to any cherry species outside the arable range, although Prunus avium is often specifically referred to as "wild cherry" in the British Isles.',
                'status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'id'=>7,
                'name'=>'Apple',
                'price'=>80,
                'thumbnail'=>'https://cdn.pixabay.com/photo/2018/05/08/21/28/apple-3384010__340.png',
                'quantity'=>100,
                'category_id'=>1,
                "description"=>"",
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
