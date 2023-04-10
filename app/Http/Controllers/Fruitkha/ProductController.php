<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    function detailProduct(Request $request)
    {
        $product = Products::find($request->id);
        $products =   $this->productRepository->getTop3Product();
        return view('client.product.single-product',["products"=>$products,"product" => $product]);
    }

    function addToCart(Request $request){
        $product = Products::find($request->id);
        $cart = session()->get('cart');
        $request->quantity  == null ? $quantity = 1 : $quantity = $request->quantity;
        if(empty($product)){
            abort(404);
        }else{
            if(isset($cart[$product->id])){
                $cart[$product->id]['quantity'] += $quantity;
            }else{
                $cart[$product->id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "thumbnail" => $product->thumbnail,
                    "quantity" => $quantity,
                    "price" => $product->price
                ];
            }
            session()->put('cart', $cart);
            return redirect()->back();

        }
    }

    function update(Request $request){
        $cart = session()->get('cart');
        if($request->id and $request->quantity){
            $cart[$request->id]['quantity'] = $request->quantity ;
            session()->put('cart', $cart);
        }
    }

    function delete(Request $request){
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }
    
public function index(){
    $products = Products::all();
    return view('admin.product-datatable', compact('products'))->with('json', $products->toJson());
}
public function create()
{
    $product = new Products;
    return view('admin.create', ['product' => $product], compact('product'));
}


/**
 * Store a newly created products in storage.
 */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'quantity' => 'required|integer|min:0',
        'status' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);

    $product = new Products;
    $product->name = $validatedData['name'];
    $product->status = $validatedData['status'];
    $product->price = $validatedData['price'];
    $product->quantity = $validatedData['quantity'];
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
public function edit($productId)
{
    $product = Products::findOrFail($productId);
    return view('admin.edit', compact('product'));
}
/**
 * Update the products in storage.
 */
public function updateProduct(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'quantity' => 'required|integer|min:0',
        'status' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);
    $product = Products::find($id);
    // dd($validatedData);
    if (count(array_filter($validatedData)) > 0) {
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->status = $validatedData['status'];
        $product->save();
        dd($product);
    }
    return redirect()->route('admin.product-datatable');
    
}

/**
 * Remove the products from storage.
 */
public function destroy($id)
{
    $product = Products::find($id);
    $product->delete();
    return redirect()->route('product-datatable');
}
    function listProductsAdmin(){
        return view("admin.table.products");
    }
    function createProductView(){
        return view("admin.form.product");
    }
}