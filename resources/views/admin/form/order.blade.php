@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Form</title>
@endsection
@section("css")
@endsection
@section("body")
    <?php
    $message = null;
    $status = null;
    if(session()->get("message_admin_order") && session()->get("status_massage")){
        $message = session()->get("message_admin_order") ?? null;
        $status = session()->get("status_massage") ?? null;
    }
    ?>
    <div class="row page-titles mx-0">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
               <div class="d-flex justify-content-between">
                   <a href="{{route('admin.form.user',["id"=>$order->user_id])}}">
                   <div class="media align-items-center mb-4">
                       <img class="mr-3" src="images/avatar/11.png" width="80" height="80" alt="">
                       <div class="media-body">
                           <h3 class="mb-0">{{$order->user->name ?? "unknown"}}</h3>
                           <p class="text-muted mb-0">{{$order->user->username ?? "unknown"}}</p>
                       </div>
                   </div>
                   </a>
                   <ul class="card-profile__info">
                       <li class="mb-1"><strong class="text-dark mr-4 p-1   ">Mobile</strong> <span>{{$order->user->phone ?? "unknown"}}</span></li>
                       <li class="mb-1"><strong class="text-dark mr-4 p-1   ">Email</strong> <span>{{$order->user->email ?? "unknown"}}</span></li>
                       <li class="mb-1"><strong class="text-dark mr-4 p-1   ">Address</strong> <span>{{$order->user->address ?? "unknown"}}</span></li>
                   </ul>
               </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Form Order</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        @if($message !== null && $status !== null)
            <div class="{{$status}} alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button> <strong>{{$message}}</strong></div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form" action="{{route("admin.order.update")}}" method="POST">
                                <input type="hidden" value="{{$order->id}}" name="id">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Name <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-username" name="name"
                                              value="{{$order->name}}"  placeholder="Enter a name..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-email">Email <span
                                              class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control"  id="email" name="email"
                                               value="{{$order->email}}" placeholder="Your valid email..">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-suggestions">Message <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" id="message" name="message"
                                                  rows="5" placeholder="What would you like to see?">
                                            {!! $order->message !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Status <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="status" name="status" >
                                            <option {{$order->status==1 ? "selected":""}} value="1">Active</option>
                                            <option {{$order->status==0 ? "selected":""}} value="0">Delete</option>
                                            <option {{$order->status==4 ? "selected":""}} value="4">Waiting</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-phoneus">Phone<span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               value="{{$order->code}}" placeholder="Your phone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-address">Address<span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="address" name="address"
                                               value="{{$order->address}}"  placeholder="Your address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive">
                                <table class="table table-xs mb-0">
                                    <thead>
                                    <tr>
                                        <th>Product thumbnail</th>
                                        <th>Unit price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Item Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->order_details as $detail)
                                    <tr>
                                        <td><img src="{{$detail->product->thumbnail}}" class=" rounded-circle mr-3" alt="">
                                            {{$detail->product->name}}
                                        </td>
                                        <td>{{$detail->price}} $</td>
                                        <td>
                                            <span>{{$detail->quantity}}</span>
                                        </td>
                                        <td><i class="fa fa-circle-o text-success  mr-2"></i> {{$detail->statusString()}}</td>
                                        <td>
                                            <span>{{$detail->price * $detail->quantity}} $</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            <span>Total: </span>
                                        </td>
                                        <td></td>
                                        <td>
                                        </td>
                                        <td> </td>
                                        <td>
                                            <span><strong class="">{{$order->total_price}}</strong> $</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
@endsection

@section("script")
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../js/order.js"></script>
@endsection