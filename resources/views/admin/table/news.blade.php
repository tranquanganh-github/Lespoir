@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Table</title>
@endsection
@section("css")
    <link href="../admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Table News</a></li>
            </ol>
        </div>
    </div>

    @if($message !== null && $status !== null)
        <div class="{{$status}} alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button> <strong>{{$message}}</strong></div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Table</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Thumbnail</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Author</th>
                                    <th>Content</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($news as $new)
                                    <tr>
                                        <td>{{ $new->id }}</td>
                                        <td>
                                            <img class="img-fluid" src="{{$new->thumbnail}}" alt="">
                                        </td>
                                        <td>{{ $new->title }}</td>
                                        <td>{{ $new->description }}</td>
                                        <td>@if($new->author_id === 1) Admin @endif</td>
                                        <td>{{ $new->content }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn mb-1 btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$new->statusString()}}
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                                                    <a class="dropdown-item" href="{{ route("admin.new.change.status",["id"=>$new->id,"status"=>1] )}}">Active</a>
                                                    <a class="dropdown-item" href="{{ route("admin.new.change.status",["id"=>$new->id,"status"=>0] )}}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $new->created_at }}</td>
                                        <td><a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route("admin.form.new",['id'=>$new->id]) }}">Edit</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
@endsection

@section("script")
    <script src="../admin/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../admin/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../admin/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
@endsection