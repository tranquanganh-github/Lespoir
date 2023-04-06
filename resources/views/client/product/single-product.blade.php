@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Prodcut Detail</title>
@endsection
@section('title-hero')
    <p>See more Details</p>
    <h1>Single Product</h1>
@endsection
@section('content-page')
<?php
    $product = (object)[
        'id' => 5,
        'name' => 'Green apples',
        'thumbnail' => 'https://themewagon.github.io/fruitkha/assets/img/products/product-img-5.jpg',
        'price' => '45'
    ];
    $cartItem = isset(session()->get('cart')[$product->id]) ? session()->get('cart')[$product->id] : null;
    $quantity = is_null($cartItem) ? 1 : $cartItem["quantity"];
?>
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{$product->thumbnail}}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }} have polyphenols</h3>
                        <p class="single-product-pricing"><span>Per Kg</span> {{ $product->price }}</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta sint dignissimos, rem commodi cum voluptatem quae reprehenderit repudiandae ea tempora incidunt ipsa, quisquam animi perferendis eos eum modi! Tempora, earum.</p>
                        <div class="single-product-form">
                            <form action="{{ route("addToCart",['id'=>$product->id]) }}">
                                <input type="number" placeholder="0" value="{{$quantity}}" name="quantity">
                                <input type="hidden" name="id" value="{{$product->id}}"></input>
                                <button type="submit" class="cart-btn">Add to Cart</button>
                                <p><strong>Categories: </strong>Fruits, Organic</p>
                            </form>
                        </div>
                        <h4>Share:</h4>
                        <ul class="product-share">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->

    <!-- more products -->
    <div class="more-products mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Related</span> Products</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="single-product.html"><img src="assets/img/products/product-img-1.jpg" alt=""></a>
                        </div>
                        <h3>Strawberry</h3>
                        <p class="product-price"><span>Per Kg</span> 85$ </p>
                        <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="single-product.html"><img src="assets/img/products/product-img-2.jpg" alt=""></a>
                        </div>
                        <h3>Berry</h3>
                        <p class="product-price"><span>Per Kg</span> 70$ </p>
                        <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="single-product.html"><img src="assets/img/products/product-img-3.jpg" alt=""></a>
                        </div>
                        <h3>Lemon</h3>
                        <p class="product-price"><span>Per Kg</span> 35$ </p>
                        <a href="" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end more products -->
@endsection