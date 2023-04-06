<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/button.css">
    <link rel="stylesheet" href="../css/load.css">
</head>
<body>
<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<div class="logo-home">
    <a href="{{route("home.page1")}}">
        <h2><i class="fa fa-arrow-left" aria-hidden="true"></i></h2>
    </a>
</div>
<div class="curve-outside-1"></div>
<div class="curve-outside-2"></div>
    <div class="container-center">
        <div class="item">
            <div class="form-login">
                <div class="form-title">
                    <h3>Login</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Successfully submitted!</strong> The form is valid.
                    </div>
                <form  role="form" action="{{route("login.post") ?? ""}}" method="POST">
                    <div class="form-group">
                        <div class="label-input">
                            <input type="text" id="username" name="username" placeholder="Username" class="error" aria-invalid="true">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label-input">
                            <input type="password" id="password" name="password"  placeholder="Password">
{{--                            <label id="username-error" class="error" for="username">Please specify your name (only letters and spaces are allowed)</label>--}}

                        </div>
                    </div>
                    <div class="login-option">
                        <div class="remember-password">
                            <input type="checkbox">
                            <span>Remember account for 30 days</span>
                        </div>
                        <a href="#">Forgot password</a>
                    </div>
                <div class="d-flex justify-content-center">
                    <button type="button" onclick="submitLogin()" class="btn btn-light hover-primary m-1">Login</button>
                    <a href="{{route('register.get')}}">
                        <button type="button" class="btn btn-light hover-primary m-1">Register</button>
                    </a>
                </div>
                </form>
                </div>
                <div class="rule">
                    Or
                </div>
                <div class="another-login">
                    <button type="button" class="login-with-google-btn" >
                        Sign in with Google
                    </button>
                    <button class="login-with-facebook-btn">
                        Login with FaceBook
                    </button>
                </div>
            </div>
            <div class="thumbnail">
                <div class="curve"></div>
                <div class="curve2"></div>
                <div class="curve3"></div>
                <div class="login-face">
                    <img src="./img/30826980_7723423.jpg" alt="">
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/ALert/alert.js"></script>
<script src="./js/LoadingSpinner/load.js"></script>
<script src="./js/Enum/enum.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>--}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // "Authorization": `Bearer ${cookie.load('token')}`
        }
    });
    const loginURL = '{{route("login.post") ?? ""}}';
</script>
<script type="text/javascript" src="../js/login.js"></script>
</body>
</html>
