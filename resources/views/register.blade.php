<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    <title>Register</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/button.css">

</head>
<body>
<div class="logo-home">
    <a href="{{route("login.get")}}">
        <h2><i class="fa fa-arrow-left" aria-hidden="true"></i></h2>
    </a>
</div>
<div class="curve-outside-1"></div>
<div class="curve-outside-2"></div>
<div class="container-center">
    <div class="item-register">
        <div class="form-register">
            <div class="form-title">
                <h3>Register</h3>
            </div>
            <form role="form"  action="#" method="POST">
      <div class="container-flex">
          <div class="container-3">
              <div class="form-group">
                  <div class="label-input">

                      <input type="text" id="username" name="username" placeholder="Username">
                  </div>
              </div>
              <div class="form-group">
                  <div class="label-input">

                      <input type="password" id="password" name="password" placeholder="Password">
                  </div>
              </div>
              <div class="form-group">
                  <div class="label-input">

                      <input type="password" id="config_password" name="config_password"
                             placeholder="Config Password">
                  </div>
              </div>
          </div>
          <div class="container-3">
              <div class="form-group">
                  <div class="label-input d-flex">
                      <input type="text" class="col-12" id="first_name" name="name" placeholder="Name">
                  </div>
              </div>
              <div class="form-group">
                  <div class="label-input">
                      <input type="email" id="email" name="email" placeholder="Email">
                  </div>
              </div>
              <div class="form-group">
                  <div class="label-input telephone">
                      <input class="form-control tel" type="tel"id="phone" name="leyka_donor_phone" placeholder="Phone" inputmode="tel" value="" />
                      <span id="valid-msg" class="hide error"></span>
                      <span id="error-msg" class="hide error"></span>
                  </div>
              </div>
          </div>
      </div>
                <div class="container-3">
                    <div class="address_details">
                        <span class="address_title">Address</span>
                        <div class="category d-flex justify-content-space-between">
                            <select name="ls_province" onchange="updateAddress()"></select>
                            <select name="ls_district" onchange="updateAddress()"></select>
                            <select name="ls_ward" onchange="updateAddress()"></select>

                            <div class="form-group">
                                <div class="label-input">
                                    <input type="text"  id="address" name="address" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="button">
                        <input type="submit" value="Đăng ký">
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./js/ALert/alert.js"></script>
<script src="./js/Enum/enum.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="./js/vietnamelocation/vietnamlocalselector.min.js"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const registerURL = '{{route("register.post") ?? ""}}';
</script>
<script type="text/javascript" src="../js/register.js"></script>
</body>
</html>
