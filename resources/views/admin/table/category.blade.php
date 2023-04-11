@extends("layouts.admin.layout-master-admin")
@section("title")
    <title>Fruitkha - Table</title>
@endsection
@section("css")
    <link href="../admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .text-n-line{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 4; /* number of lines to show */
            line-height: 4;        /* fallback */
            max-height: 50px;       /* fallback */
        }
    </style>
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
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Table Categories</a></li>
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
                        <h4 class="card-title">Categories</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn mb-1 btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$category->statusString()}}
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
                                                    <a class="dropdown-item" href="{{route("admin.order.update",["id"=>$category->id,"status"=>1])}}">Active</a>
                                                    <a class="dropdown-item" href="{{route("admin.order.update",["id"=>$category->id,"status"=>0])}}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$category->created_at}}</td>
                                        <td><a class="btn btn-danger" href="{{ route("admin.table.categories.update",['id'=>$category->id]) }}">Edit</a></td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
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