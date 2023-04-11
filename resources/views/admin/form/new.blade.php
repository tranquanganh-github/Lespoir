@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Form</title>
@endsection
@section("css")
    <link href="../admin/plugins/summernote/dist/summernote.css" rel="stylesheet">
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
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Form New</a></li>
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
                            <form action="{{ route("admin.form.new.edit",['id'=>$new['id']]) }}" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-username">Title <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="val-username" name="title"
                                               value="{{$new->title ?? null}}"  placeholder="Enter a title..">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Description <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control h-150px" rows="6" name="description" id="description">
                                            {!! $new->description ?? "" !!}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Content <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control h-150px" rows="6" name="content" id="description">
                                            {!! $new->content ?? "" !!}
                                        </textarea>
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
                                            <input type="text" class="form-control" onchange="imageChange(this)" name="thumbnail" placeholder="Upload File" id="file">
                                            <div class="input-group-append">
                                                <button type="button" class="browse btn btn-primary">Browse...</button>
                                            </div>
                                        </div>
                                        <img src="{{ $new->thumbnail ?? null}}" id="preview" class="img-thumbnail">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Author <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="status" name="author_id" >
                                            <option {{ isset($new->author_id) ? $new->author_id==1 ? "selected":"" : null }} value="1">Admin</option>
                                            <option {{ isset($new->author_id) ? $new->author_id==0 ? "selected":"" : null }} value="0">Not Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-skill">Status <span
                                                class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="status" name="status" >
                                            <option {{ isset($new->status) ? $new->status==1 ? "selected":"" : null }} value="1">Active</option>
                                            <option {{ isset($new->status) ? $new->status==0 ? "selected":"" : null }} value="0">Delete</option>
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

    <script src="../admin/plugins/summernote/dist/summernote.min.js"></script>
    <script src="../admin/plugins/summernote/dist/summernote-init.js"></script>
@endsection