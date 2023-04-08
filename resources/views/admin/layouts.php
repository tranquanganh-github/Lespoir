<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Update products</title>
</head>

<body>
<div class="container">
        <h1>@yield('Product-form')</h1>
        <div class="row">
            <div class="col-md-6">
              @yield('content')
            </div>
          </div>
    </div>
    <!-- Add your scripts here -->
    @yield('scripts')
</body>

</html>