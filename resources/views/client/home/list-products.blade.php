<div class="container">
    <div class="row">
        <div class="col-lg-8 offset-lg-2 text-center">
            <div class="section-title">
                <h3><span class="orange-text">Our</span> Products</h3>
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

        <!-- <div class="col-lg-4 col-md-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="single-product.html"><img src="assets/img/products/product-img-2.jpg" alt=""></a>
                </div>
                <h3>Berry</h3>
                <p class="product-price"><span>Per Kg</span> 70$ </p>
                <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="single-product.html"><img src="assets/img/products/product-img-3.jpg" alt=""></a>
                </div>
                <h3>Lemon</h3>
                <p class="product-price"><span>Per Kg</span> 35$ </p>
                <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            </div>
        </div> -->
    </div>

</div>