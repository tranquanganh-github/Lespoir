<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Webpage example using DataTables and JQuery</title>	
  <!-- Import Bootstrap and JQuery -->
  <link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  <script 
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">    
  </script>        
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <!-- DataTables -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">   
  </script>
  <!-- My CSS and JQuery -->
  <link href="./css/style.css" rel="stylesheet">
  
  <script type="text/javascript" src="./jquery/index.js"></script> 
</head>
<body>
<div class="container-fluid">
  <h1 class="display-4 my-4 text-info">List of users</h1>
  <table class="table table-striped" id="example" style="width: 100%;">
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
          <td><a class="btn btn-success" onclick="return confirm('Are you sure?')" href="/users/{{$user->id}}">UnBlock</a></td>
        @else
          <td><a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="/users/{{$user->id}}">Block</a></td>
        @endif
        </tr> 
    @endforeach
    </tbody>
  </table>
</div>
</body>

<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
   $(document).ready(function() {

       var table = $('#example').DataTable([{
           select: true,
           "columnDefs": {
               className: "Name",
               "targets":[0],
               "visible": false,
               "searchable":false
           }
       }]);//End of create main table


       $('#example tbody').on( 'click', 'tr', function () {

           //alert(table.row( this ).data()[0]);

       } );
   });
</script>


</html>	
