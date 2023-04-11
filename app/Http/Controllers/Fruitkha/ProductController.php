<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Controllers\Controller;
use App\Http\Repository\CategoryRepository;
use App\Http\Repository\ProductRepository;
use App\Http\Respone\ProductRespone;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Cloundinary;

class ProductController extends Controller
{
    use ProductRespone;

    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * lấy ra chi tiết sản phẩm phía người dùng
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function detailProduct(Request $request)
    {
        $product = Products::find($request->id);
        /*lấy ra 3 sản phẩm mới tạo*/
        $products = $this->productRepository->getTop3Product();
        return view('client.product.single-product', ["products" => $products, "product" => $product]);
    }


    /**
     * thêm sản phẩm vào trong giỏ háng session
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function addToCart(Request $request)
    {
        /*tìm kiếm sản phẩm*/
        $product = Products::find($request->id);
        /*lấy rỏ hàng trong session*/
        $cart = session()->get('cart');
        /*check nếu không gửi kèm theo số lượng thì sẽ cộng 1 vào giỏ hàng*/
        $request->quantity == null ? $quantity = 1 : $quantity = $request->quantity;
        if (empty($product)) {
            /*thông báo lỗi*/
            abort(404);
        } else {
            if (isset($cart[$product->id])) {
                /*cộng số lượng lên*/
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                /*nếu chưa có sản phẩm trong giỏ hàng thì tạo mới item giỏi hàng*/
                $cart[$product->id] = [
                    "id" => $product->id,
                    "name" => $product->name,
                    "thumbnail" => $product->thumbnail,
                    "quantity" => $quantity,
                    "price" => $product->price
                ];
            }
            /*đẩy vào trong session*/
            session()->put('cart', $cart);
            return redirect()->back();

        }
    }

    /**
     *  cập nhập giỏi hàng
     * @param Request $request
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function update(Request $request)
    {

        $cart = session()->get('cart');
        if ($request->id and $request->quantity) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
    }

    /**
     * xóa sản phẩm trong giỏ hàng
     * @param Request $request
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
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


    /**
     * danh sách sản phẩm cho admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Products::select()->orderBy('created_at')->get();
        return view("admin.table.products", compact('products'))->with('json', $products->toJson());
    }


    /**
     * form update sản phẩm cho phía admin
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * cập nhật thông tin sản phẩm
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Request $request)
    {
        /*khởi tạo đối tượng cloundinary*/
        $colud = new Cloundinary();
        $id = $request->id;
        /*tiến hành validate*/
        $validatedData = $request->validate([
            "name" => 'required|max:255',
            "quantity" => 'required|integer|min:0',
            'status' => 'required|integer',
            'price' => 'required|numeric|min:0'
        ]);
            /*check xem ảnh của sản phẩm có thay đôi không*/
        if (isset($request->img) && !is_null($request->img) ){
            /*tiến hành đẩy ảnh lên clound và lấy link ảnh mới về*/
            $result = $colud->uploadImage($request,'img',$request->name);
            $validatedData["thumbnail"] = $result;
        }else{
            if ( isset($request->thumbnail_link) && !is_null($request->thumbnail_link)){
                /*kiểm tra xem người dùng có gửi link ảnh thay vì file không
                nếu có thì lấy link ảnh đẩy lên cloud và cập nhật lại sản phẩm*/
                $result = $colud->uploadImageByLink($request->thumbnail_link,$request->name);
                $validatedData["thumbnail"] = $result;
            }
        }
        /*tiến hành cập nhật sản phẩm theo id*/
        $result = $this->productRepository->updateProductById($id,$validatedData);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);

    }


    /**
     * chuyển đổi trạng thái sản phẩm phía admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request)
    {
        $result = $this->productRepository->updateProductById($request->id, ["status" => $request->status]);
        $messageSuccess = "Update product success!";
        $messageFail = "Update product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * form tạo sản phẩm
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function createProductView()
    {
        $url  = route('admin.table.products.create');
        /*lấy ra danh sách danh mục có trạng thái là active*/
        $categories = $this->categoryRepository->getAllCategory()->filter(function ($category){
            return $category->status != 0;
        });
        return view("admin.form.product",compact('url','categories'));
    }


    /**
     * tiến hành tạo sản phẩm
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $messageSuccess = "Create product success!";
        $messageFail = "Create product fail!";
        $colud = new Cloundinary();
        /*validate*/
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
            /*upload file ảnh lên cloud và lấy link ảnh về*/
            $result = $colud->uploadImage($request,'img',$request->name);
            $validatedData["thumbnail"] = $result;
        }else{
            if ( isset($request->thumbnail_link) && !is_null($request->thumbnail_link)){
                /*tương tự với link*/
                $result = $colud->uploadImageByLink($request->thumbnail_link,$request->name);
                $validatedData["thumbnail"] = $result;
            }else{
                /*trả về thông báo lỗi khi không có ảnh*/
                return $this->responeResultWithMessage(false, $messageSuccess, $messageFail);
            }
        }
        /*tạo sản phẩm*/
        $result = $this->productRepository->createProduct($validatedData);
        $messageSuccess = "Create product success!";
        $messageFail = "Create product fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * check sản phẩm có tồn tại không theo tên
     * @param $name
     * @return bool
     */
    function checkProductExist($name){
        $product = $this->productRepository->getProductByName($name);
        if ($product->count() >= 1){
            return true;
        }
        return false;
    }
}