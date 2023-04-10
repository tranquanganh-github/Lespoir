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
    if(session()->get("message_admin_user") && session()->get("status_massage")){
        $message = session()->get("message_admin_user") ?? null;
        $status = session()->get("status_massage") ?? null;
    }
    ?>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route("admin.dashboard")}}">Table Users</a></li>
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
                        <h4 class="card-title">Users</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead >
                                <tr id="list-header">
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">isBlocked</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->status}}</td>
                                        @if($user->status ==0)
                                            <td><a class="btn btn-success" onclick="return confirm('Are you sure?')" href="{{route("admin.user.update",["id"=>$user->id,"status"=>1])}}">UnBlock</a></td>
                                        @else
                                            <td><a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{route("admin.user.update",["id"=>$user->id,"status"=>0])}}">Block</a></td>
                                        @endif
                                        <td><a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{ route("admin.form.user",['id'=>$user->id]) }}">Edit</a></td>
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