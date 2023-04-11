@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Prodcut Detail</title>
@endsection
@section('title-hero')
    <p>See more Details</p>
    <h1>Single Product</h1>
@endsection
@section('home-css')
    <style>
        .text-n-line{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            /*-webkit-line-clamp: 8; !* number of lines to show *!*/
            /*line-height: 8;        !* fallback *!*/
            max-height: 400px;       /* fallback */
        }
    </style>
@endsection
@section('content-page')
<?php
    $cartItem = isset(session()->get('cart')[$product['id']]) ? session()->get('cart')[$product['id']] : null;
    $quantity = is_null($cartItem) ? 1 : $cartItem["quantity"] ;
?>
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{$product['thumbnail']}}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product['name'] }}</h3>
                        <p class="single-product-pricing"><span>Per Kg</span>$ {{ $product['price'] }}</p>
                        <p class="text-n-line">
                        {!! $product["description"] !!}
                        </p>
                        <div class="single-product-form">
                            <form action="{{ route("addToCart",['id'=>$product['id']]) }}">
                                <input type="number" placeholder="0" value="{{$quantity}}" name="quantity">
                                <input type="hidden" name="id" value="{{$product['id']}}"></input>
                                <button type="submit" style="    margin-left: 36px;" class="mb-lg-n1 btn btn-outline-dark">Add to Cart</button>
                                <p><strong>Categories: </strong>{{$product["category"]["name"]}}</p>
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
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center strawberry">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route("detail-product",['id'=>$product->id]) }}"><img src="{{ $product->thumbnail }}" alt=""></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price"><span>Quantity:{{ $product->quantity }}</span> {{ $product->price }}$ </p>
                            <a href="{{ route("addToCart",['id'=>$product->id]) }}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end more products -->
@endsection