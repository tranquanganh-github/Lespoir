@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Cart</title>
@endsection
@section('title-hero')
    <p>FRESH AND ORGANIC</p>
    <h1>Cart</h1>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(".update-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            let id = ele.attr("data-id");
            $.ajax({
                url: '{{route("cart.update")}}',
                method: "post",
                data: {
                    id: id,
                    quantity: $("input[name=quantity_"+id+"]").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            let id = ele.attr("data-id");
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{route("cart.delete")}}',
                    method: "post",
                    data: {
                        id: id,
                        quantity: $("input[name=quantity_"+id+"]").val()
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection
@section('content-page')
    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-remove"></th>
                                <th class="product-image">Product Image</th>
                                <th class="product-name">Name</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0;?>
                            @if(session('cart') != null)
                                @foreach(session('cart') as $id => $row)
                                    <?php $total += $row['quantity'] * $row['price'];?>
                                        <tr class="table-body-row">
                                            <td class="product-remove" data-th="">
                                                <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fas fa-air-freshener"></i></button>
                                                <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                            <td class="product-image"><a href="{{ route("detail-product",['id'=>$row['id']]) }}"><img src="{{$row['thumbnail']}}" alt=""></a></td>
                                            <td class="product-name"><a href="{{ route("detail-product",['id'=>$row['id']]) }}">{{$row['name']}}</a></td>
                                            <td class="product-price">{{$row['price']}}</td>
                                            <td class="product-quantity" data-th="Quantity"><input type="number" value="{{$row['quantity']}}" name="quantity_{{$id}}"></td>
                                            <td class="product-total">{{$row['quantity']}}</td>
                                        </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Total</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="total-data">
                                <td><strong>Subtotal: </strong></td>
                                <td>$<?php echo $total;?></td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>Shipping: </strong></td>
                                <td>$10</td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>Total: </strong></td>
                                <td>${{$total+=10}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons">
                            {{--                            <a href="" class="boxed-btn">Clear All</a>--}}
                            <a href="checkout.html" class="boxed-btn black">Check Out</a>
                        </div>
                    </div>

{{--                    <div class="coupon-section">--}}
{{--                        <h3>Apply Coupon</h3>--}}
{{--                        <div class="coupon-form-wrap">--}}
{{--                            <form action="index.html">--}}
{{--                                <p><input type="text" placeholder="Coupon"></p>--}}
{{--                                <p><input type="submit" value="Apply"></p>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->

@endsection