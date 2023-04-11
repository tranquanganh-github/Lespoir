@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Shop</title>
@endsection
@section('title-hero')
    <p>Fresh and Organic</p>
    <h1>Shop</h1>
@endsection
@section('content-page')

    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            @if(isset($minMax))
                                <a href="{{route("shop")}}">
                                    <li class="active">
                                        All
                                    </li>
                                </a>
                                @foreach($minMax as $el)
                                    <a href="{{route("shop",["min"=>$el["min"],"max"=>$el["max"]])}}">
                                        <li>{{$el["min"]}}$ - {{$el["max"]}}$</li>
                                    </a>
                                @endforeach
                            @endif
                        </ul>
                        <ul>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <a href="{{route("shop",["category_id"=>$category])}}">
                                        <li>{{$category->name}}</li>
                                    </a>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row product-lists">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center strawberry">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route("detail-product",['id'=>$product->id]) }}"><img
                                            src="{{ $product->thumbnail }}" alt=""></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <div class="col-lg-8" style="margin: 0 auto">
                                <div class=" d-flex justify-content-between">
                                    <span>    Quantity: {{ $product->quantity }}</span>
                                    <span>    Category: {{ $product->category->name ?? "" }}</span>
                                </div>
                            </div>
                            <p class="product-price">
                               {{ $product->price }}$
                            </p>
                            <a href="{{ route("addToCart",['id'=>$product->id]) }}" class="cart-btn"><i
                                        class="fas fa-shopping-cart"></i> Add to Cart</a>
                        </div>
                    </div>

                @endforeach
            </div>
            <!-- <div class="col-lg-4 col-md-6 text-center berry">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="assets/img/products/product-img-2.jpg" alt=""></a>
                    </div>
                    <h3>Berry</h3>
                    <p class="product-price"><span>Per Kg</span> 70$ </p>
                    <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center lemon">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="assets/img/products/product-img-3.jpg" alt=""></a>
                    </div>
                    <h3>Lemon</h3>
                    <p class="product-price"><span>Per Kg</span> 35$ </p>
                    <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="assets/img/products/product-img-4.jpg" alt=""></a>
                    </div>
                    <h3>Avocado</h3>
                    <p class="product-price"><span>Per Kg</span> 50$ </p>
                    <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="assets/img/products/product-img-5.jpg" alt=""></a>
                    </div>
                    <h3>Green Apple</h3>
                    <p class="product-price"><span>Per Kg</span> 45$ </p>
                    <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center strawberry">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="single-product.html"><img src="assets/img/products/product-img-6.jpg" alt=""></a>
                    </div>
                    <h3>Strawberry</h3>
                    <p class="product-price"><span>Per Kg</span> 80$ </p>
                    <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                </div>
            </div> -->

            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="pagination-wrap">
                    {{--                        <ul>--}}
                    <!-- <li><a href="#">Prev</a></li>
                            <li><a href="#">1</a></li>
                            <li><a class="active" href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">Next</a></li> -->
                        @include('client.pagination.default', ['paginator' => $products])
                        {{--                          <li>{{$products->links()}}</li>  --}}
                        {{--                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- end products -->

@endsection