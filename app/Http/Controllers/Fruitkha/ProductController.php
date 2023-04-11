<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Respone\ProductRespone;
use App\Models\Products;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Cloundinary;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{
    use ProductRespone;

    protected ProductRepository $productRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get product and top 3 products to display in single-product page.
     * @param Request $request
     * @return Application|Factory|View
     */
    function detailProduct(Request $request): View|Factory|Application
    {
        $product = Products::find($request->id);
        $products = $this->productRepository->getTop3Product();
        return view('client.product.single-product', ["products" => $products, "product" => $product]);
    }
    // EOF

    /**
     * Add product to cart.
     * @param Request $request
     * @return RedirectResponse|void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function addToCart(Request $request){
        $product = Products::find($request->id);
        $cart = session()->get('cart');
        $request->quantity == null ? $quantity = 1 : $quantity = $request->quantity;
        // Check product exist.
        if (empty($product)) {
            abort(404);
        } else {
            // Check product exist in cart, if not add product to cart.
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
    // EOF

    /**
     * Update quantity of product in cart.
     * @param Request $request
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function update(Request $request): void
    {
        $cart = session()->get('cart');
        if ($request->id and $request->quantity) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
    }
    // EOF

    /**
     * Remove the products from cart.
     * @param Request $request
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function delete(Request $request): void
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }
    // EOF

    //for admin
    public function index()
    {
        $products = Products::select()->orderBy('created_at')->get();

        return view("admin.table.products", compact('products'))->with('json', $products->toJson());
    }

    public function create()
    {
        $product = new Products;
        return view('admin.product-create', ['product' => $product], compact('product'));
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
    public function edit(Request $request)
    {
        $product = $this->productRepository->getProductById($request->id)->first();
        $url = route('admin.table.products.update');
        $categories = $this->categoryRepository->getAllCategory()->filter(function ($category){
            return $category->status != 0;
        });
        return view('admin.form.product', compact('categories','product','url'));
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

    }

    /**
     * Remove the products from storage.
     */
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
        $categories = $this->categoryRepository->getAllCategory()->filter(function ($category){
            return $category->status != 0;
        });
        return view("admin.form.product",compact('url','categories'));
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
            "category_id" => 'required|integer',
            "description" => 'required',
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
    }
}