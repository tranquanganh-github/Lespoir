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
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * returns the user-side shop page
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function shopView(Request $request)
    {
        /*take out the most expensive and cheapest product and divide it into sub-arrays*/
        $minMax = $this->getMinMaxPrice();
        /*retrieve filterable products according to the input condition*/
        $products = $this->getAllProduct($request);
        /*get list of categories*/
        $categories = $this->categoryRepository->getAllCategory();
        /*paginate and get a limit of 6*/
        $products = $products->paginate(6);
        /*data binding and return view*/
        return view('client.shop.shop', compact("categories","products", "minMax"));
    }

    /**
     * returns the array of the most expensive and cheapest product
     * @return array
     */
    function getMinMaxPrice()
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

    /**
     * return cart view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function cartView()
    {
        return view('client.cart.cart');
    }
    /*
     * Returns product list with conditions attached
     * */
    function getAllProduct(Request $request)
    {
        $products = $this->productRepository->getAllOfProduct($request);
        return $products;
    }
}