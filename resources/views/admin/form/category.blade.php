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
    if(session()->get("message_admin_category") && session()->get("status_massage")){
        $message = session()->get("message_admin_category") ?? null;
        $status = session()->get("status_massage") ?? null;
    }
    ?>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Form Category</a></li>
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
                            <form class="form" action="{{$url ?? ""}}" method="POST">
                                <input type="hidden" value="{{$category->id ?? null}}" name="id">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Name <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-username" name="name"
                                               value="{{$category->name ?? null}}"  placeholder="Enter a name..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Status <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="status" name="status" >
                                            <option {{isset($category->status) ? $category->status==1 ? "selected":"" : null}} value="1">Active</option>
                                            <option {{isset($category->status) ? $category->status==0 ? "selected":"" : null}} value="0">Delete</option>
                                        </select>
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