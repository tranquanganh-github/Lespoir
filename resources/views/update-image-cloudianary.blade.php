<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        img{
            width: 200px;
            margin: 50px;
        }
    </style>
</head>
<body>
<h2>Cloundinary</h2>

<form action="{{route('updateload-img')}}" method="POST">
    <input type="file" name="file">
    <input type="submit">
</form>

</body>
</html>