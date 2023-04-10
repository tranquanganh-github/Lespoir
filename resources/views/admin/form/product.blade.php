@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Form</title>
@endsection
@section("css")
    <style>
        .file {
            visibility: hidden;
            position: absolute;
        }
    </style>
@endsection
@section("body")
    <?php
    $message = null;
    $status = null;
    if(session()->get("message_admin_product") && session()->get("status_massage")){
        $message = session()->get("message_admin_product") ?? null;
        $status = session()->get("status_massage") ?? null;
    }
    ?>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Form Product</a></li>
            </ol>
        </div>
    </div>
    @if($message !== null && $status !== null)
        <div class="{{$status}} alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button> <strong>{{$message}}</strong></div>
    @endif
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">
                            <form class="form" action="{{$url ?? ""}}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" value="{{$product->id ?? null}}" name="id">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Name <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-username" name="name"
                                               value="{{$product->name ?? null}}"  placeholder="Enter a name..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Status <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="status" name="status" >
                                            <option {{isset($product->status) ? $product->status==1 ? "selected":"" : null}} value="1">Active</option>
                                            <option {{isset($product->status) ? $product->status==0 ? "selected":"" : null}} value="0">Delete</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-phoneus">Quantity<span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="quantity" name="quantity"
                                               value="{{$product->quantity ?? null}}" placeholder="Your Quantity">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-phoneus">Price<span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="quantity" name="price"
                                               value="{{$product->price ?? null}}" placeholder="Your Quantity">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Thumbnail <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="ml-2 col-sm-6">
                                        <div id="msg"></div>

                                            <input type="file" name="img" class="file" accept="image/*">
                                            <div class="input-group my-3">
                                                <input type="text" class="form-control" onchange="imageChange(this)" name="thumbnail_link" placeholder="Upload File" id="file">
                                                <div class="input-group-append">
                                                    <button type="button" class="browse btn btn-primary">Browse...</button>
                                                </div>
                                            </div>


                                            <img src="{{$product->thumbnail??null}}" id="preview" class="img-thumbnail">

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
        </div>
    </div>
    <!-- #/ container -->
@endsection

@section("script")

    <script>
        function imageChange(element){
            var link = $(element).val();
            document.getElementById("preview").src = link;
        }
        $(document).on("click", ".browse", function() {
            var file = $(this).parents().find(".file");
            file.trigger("click");
        });
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $("#file").val(fileName);

            var reader = new FileReader();
            reader.onload = function(e) {
                // get loaded data and render thumbnail.
                document.getElementById("preview").src = e.target.result;
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);


        });

    </script>

@endsection