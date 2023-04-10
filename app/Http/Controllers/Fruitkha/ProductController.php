<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepository;
use App\Http\Respone\ProductRespone;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Cloundinary;

class ProductController extends Controller
{
    use ProductRespone;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    function detailProduct(Request $request)
    {
        $product = Products::find($request->id);
        $products = $this->productRepository->getTop3Product();
        return view('client.product.single-product', ["products" => $products, "product" => $product]);
    }

    function addToCart(Request $request)
    {
        $product = Products::find($request->id);
        $cart = session()->get('cart');
        $request->quantity == null ? $quantity = 1 : $quantity = $request->quantity;
        if (empty($product)) {
            abort(404);
        } else {
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
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

    function update(Request $request)
    {
        $cart = session()->get('cart');
        if ($request->id and $request->quantity) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
    }

    function delete(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }
<<<<<<< HEAD
    public function index()
    {
        $products = Products::all();
        return view('admin.product-datatable', compact('products'))->with('json', $products->toJson());
    }
=======

    //for admin
    public function index()
    {
        $products = Products::all();
        return view("admin.table.products", compact('products'))->with('json', $products->toJson());
    }

>>>>>>> origin/dev
    public function create()
    {
        $product = new Products;
        return view('admin.product-create', ['product' => $product], compact('product'));
    }

<<<<<<< HEAD

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

=======
>>>>>>> origin/dev
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
<<<<<<< HEAD
    public function edit($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return view('admin.product-datatable')->with('error', 'Product not found');
        }
        return view('admin.product-edit', compact('product'));
    }


    /**
     * Update the products in storage.
     */
    public function updateProduct(Request $request, Products $product)
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
=======
    public function edit(Request $request)
    {
        $product = $this->productRepository->getProductById($request->id)->first();
        $url = route('admin.table.products.update');
        return view('admin.form.product', compact('product','url'));
    }

    /**
     * Update the products in storage.
     */
    public function updateProduct(Request $request)
    {
        $colud = new Cloundinary();
        $id = $request->id;
        $validatedData = $request->validate([
            "name" => 'required|max:255',
            "quantity" => 'required|integer|min:0',
            'status' => 'required|integer',
            'price' => 'required|numeric|min:0'
        ]);

        if (isset($request->img) && !is_null($request->img) ){

            $result = $colud->uploadImage($request,'img',$request->name);
            $validatedData["thumbnail"] = $result;
        }else{
            if ( isset($request->thumbnail_link) && !is_null($request->thumbnail_link)){

                $result = $colud->uploadImageByLink($request->thumbnail_link,$request->name);
                $validatedData["thumbnail"] = $result;
            }
        }
        $result = $this->productRepository->updateProductById($id,$validatedData);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
>>>>>>> origin/dev

    }

    /**
     * Remove the products from storage.
     */
<<<<<<< HEAD
    public function destroy($id)
    {
        $products = Products::find($id);
        $products->delete();
        dd($products);
        return redirect()->route('admin.product-datatable');
=======
    public function changeStatus(Request $request)
    {
        $result = $this->productRepository->updateProductById($request->id, ["status" => $request->status]);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    function createProductView()
    {
        $url  = route('admin.table.products.create');
        return view("admin.form.product",compact('url'));
    }

    /**
     * Store a newly created products in storage.
     */
    public function store(Request $request)
    {
        $messageSuccess = "Create product success!";
        $messageFail = "Create product fail!";
        $colud = new Cloundinary();
        $validatedData = $request->validate([
            "name" => 'required|max:255',
            "quantity" => 'required|integer|min:0',
            'status' => 'required|integer',
            'price' => 'required|numeric|min:0'
        ]);
        //check Product name exist
        $productIsExist = $this->checkProductExist($request->name);
        if ($productIsExist == true){
            $messageFail = "Tên sản phẩm đã tồn tại";
            return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
        }
        if (isset($request->img) && !is_null($request->img) ){
            $result = $colud->uploadImage($request,'img',$request->name);
            $validatedData["thumbnail"] = $result;
        }else{
            if ( isset($request->thumbnail_link) && !is_null($request->thumbnail_link)){
                $result = $colud->uploadImageByLink($request->thumbnail_link,$request->name);
                $validatedData["thumbnail"] = $result;
            }else{
                return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
            }
        }
        $result = $this->productRepository->createProduct($validatedData);
        $messageSuccess = "Create product success!";
        $messageFail = "Create product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }
    function checkProductExist($name){
        $product = $this->productRepository->getProductByName($name);
        if ($product->count() >= 1){
            return true;
        }
        return false;
>>>>>>> origin/dev
    }
}