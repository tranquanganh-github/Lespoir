@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Check out</title>
@endsection
@section('title-hero')
    <p>FRESH AND ORGANIC</p>
    <h1>Check Out Product</h1>
@endsection
@section('home-javascript')
    <script>
       const CheckoutUrl = "{{route("payment.delivery")}}"
       const PayPalCheckoutUrl = "{{route("payment.paypal")}}"
    </script>
    <script type="text/javascript" src="../js/checkout.js"></script>
@endsection
@section('content-page')
    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Billing Address
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form action="">
                                                <p><input type="text" value="{{$user->name ?? ""}}" name="name" placeholder="Name"></p>
                                                <p><input type="email" value="{{$user->email ?? ""}}" name="email" placeholder="Email"></p>
                                                <p><input type="text" value="{{$user->address ?? ""}}" name="address" placeholder="Address"></p>
                                                <p><input type="tel" value="{{$user->phone ?? ""}}" name="phone" placeholder="Phone"></p>
                                                <p><textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Shipping Address
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <p>My shop is open at IP address localhost.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Payment methods
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <p>Your card details goes here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="order-details-wrap">

                        <table class="order-details">
                            <thead>
                            <tr>
                                <th>Your order Details</th>
                                <th>Quantity</th>
                                <th>Unit Price ($)</th>
                                <th>Price ($)</th>
                            </tr>
                            </thead>
                            <tbody class="order-details-body">
                    @if(!is_null($carts))
                        @foreach($carts as $key => $cart)
                            <tr class="data-cart" data-name="{{$cart["name"]}}"
                                data-id="{{$cart["id"]}}"
                                data-quantity="{{$cart["quantity"]}}"
                                data-price="{{$cart["price"]}}">
                                <td>{{$cart["name"]}}</td>
                                <td>{{$cart["quantity"]}}</td>
                                <td>{{$cart["price"]}}</td>
                                <td>{{$cart["quantity"] * $cart["price"]}}</td>
                            </tr>
                        @endforeach
                    @endif
                            </tbody>
                            <tbody class="checkout-details">
                            <tr>
                                <td>Subtotal</td>
                                <td></td>
                                <td></td>
                                <td>{{$sum ?? 0}}</td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td></td>
                                <td><input type="hidden" class="shipping-price" value="{{$ship ?? 0}}"></td>
                                <td>{{$ship ?? 0}}</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td>{{$sum + $ship}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="#" onclick="order(event)" class="boxed-btn">Payment upon receipt</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end check out section -->
@endsection
