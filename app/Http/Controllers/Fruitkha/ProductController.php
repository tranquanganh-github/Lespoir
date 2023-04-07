<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Datatables;

class ProductController extends Controller
{
    function detailProduct()
    {
        $cart = session()->get("cart");

        return view('client.product.single-product');
    }

    public function index(){
        $product = Products::all();
        return view('admin.product-datatable', compact('product'))->with('json', $product->toJson());
    }
    public function create()
    {
        $product = new Products;
        return view('admin.product-create', ['product' => $product], compact('product'));
    }


    /**
     * Store a newly created products in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        $product = new Products;
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->price = $validatedData['quantity'];
        $product->save();
        return redirect()->route('products.product-datatable');
    }

    /**
     * Display the products.
     */
    public function show(Products $product)
    {
        return view('admin.product-datatable', compact('product'));
    }

    /**
     * Show the form for editing products.
     */
    public function edit(Products $product)
    {
        $product = Products::find($product->id);
        return view('admin.product-edit', compact('product'));
    }

    /**
     * Update the products in storage.
     */
    public function update(Request $request, Products $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        if (count(array_filter($validatedData)) > 0) {
            $product->name = $validatedData['name'];
            $product->price = $validatedData['price'];
            $product->amount = $validatedData['amount'];
            $product->description = $validatedData['description'];
            $product->save();
        }
        
    }

    /**
     * Remove the products from storage.
     */
    public function destroyProduct(Products $products)
    {
        $products->delete();
        return redirect()->route('products.product-datatable');
    }
}