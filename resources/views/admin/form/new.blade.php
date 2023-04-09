@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Form</title>
@endsection
@section("css")
    <link href="../admin/plugins/summernote/dist/summernote.css" rel="stylesheet">
@endsection
@section("body")
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Form New</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="summernote">
                            <h3>Default Summernote</h3>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="inline-editor">
                            <h4 class="card-title m-b-40">You can select content and edit inline</h4>
                            <h3>Title Heading will be <b>apear here</b></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elitconsectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud Exercitation ullamco laboris
                                nisi ut aliquip ex ea commodo consequat.</p>
                            <ul class="list-icons">
                                <li><i class="fa fa-check text-success"></i> Lorem ipsum dolor sit amet</li>
                                <li><i class="fa fa-check text-success"></i> Consectetur adipiscing elit</li>
                                <li><i class="fa fa-check text-success"></i> Integer molestie lorem at massa</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="click2edit m-b-40">Click on Edite button and change the text then save it.</div>
                        <button id="edit" class="btn btn-info btn-rounded" onclick="edit()" type="button">Edit</button>
                        <button id="save" class="btn btn-success btn-rounded" onclick="save()" type="button">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
@endsection

@section("script")


    <script src="../admin/plugins/summernote/dist/summernote.min.js"></script>
    <script src="../admin/plugins/summernote/dist/summernote-init.js"></script>
@endsection