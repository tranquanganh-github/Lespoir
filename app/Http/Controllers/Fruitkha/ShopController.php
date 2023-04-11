<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    function shopView(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $minMax = $this->getMinMaxPrice();
        $products = $this->getAllProduct($request);
        $categories = $this->categoryRepository->getAllCategory();
        $products = $products->paginate(6);
        return view('client.shop.shop', compact("categories","products", "minMax"));
    }

    function getMinMaxPrice(): array
    {
        $key = "min_max_product";
        $price = Cache::get($key);
        if ($price == null) {
            $price = $this->productRepository->getMinMaxPrice();
            Cache::put($key, $price, 400);
        }
        $num = 4;
        $rang = ($price["max"] - $price["min"]) / $num;
        $filterArray = [];
        for ($i = 0; $i < $num; $i++) {
            array_push($filterArray, [
                "min" => ceil($price["min"]),
                "max" => ceil($price["min"] += $rang),
            ]);
        }
        return $filterArray;
    }

    function cartView(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('client.cart.cart');
    }

    function getAllProduct(Request $request)
    {
        $products = $this->productRepository->getAllOfProduct($request);
        return $products;
    }
}