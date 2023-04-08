<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
 @yield("title")
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../admin/images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="../admin/css/style.css" rel="stylesheet">
    @yield("css")

</head>

<body>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <div class="brand-logo">
            <a href="index.html">
                <b class="logo-abbr"><img src="../admin/images/logo.png" alt=""> </b>
                <span class="brand-title">
                        <img src="../admin/images/logo-text.png" alt="">
                    </span>
            </a>
        </div>
    </div>
    <!--**********************************
        Nav header end
    ***********************************-->

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content clearfix">

            <div class="nav-control">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
            <div class="header-right">
                <ul class="clearfix">
                    <li class="icons dropdown d-none d-md-flex">
                        <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                            <span>English</span>  <i class="fa fa-angle-down f-s-14" aria-hidden="true"></i>
                        </a>
                        <div class="drop-down dropdown-language animated fadeIn  dropdown-menu">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li><a href="javascript:void()">English</a></li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="icons dropdown">
                        <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                            <span class="activity active"></span>
                            <img src="../admin/images/user/1.png" height="40" width="40" alt="">
                        </div>
                        <div class="drop-down dropdown-profile   dropdown-menu">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li>
                                        <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                                    </li>
                                    <li><a href="page-login.html"><i class="icon-key"></i> <span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

    <!--**********************************
        Sidebar start
    ***********************************-->
    <div class="nk-sidebar">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu">
                <li class="nav-label">Menu</li>
                <li>
                    <a  href="javascript:void()">
                        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                    </a>
{{--                    <ul aria-expanded="false">--}}
{{--                        <li><a href="../index.html">Home 1</a></li>--}}
{{--                        <!-- <li><a href="../index-2.html">Home 2</a></li> -->--}}
{{--                    </ul>--}}
                </li>

                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-envelope menu-icon"></i> <span class="nav-text">Email</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route("admin.email.inbox")}}">Inbox</a></li>
                        <li><a href="{{route("admin.email.read")}}">Read</a></li>
                        <li><a href="{{route("admin.email.compose")}}">Compose</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Apps</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route("admin.app.calendar")}}">Calender</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-menu menu-icon"></i><span class="nav-text">Table</span>
                    </a>
{{--                    <ul aria-expanded="false">--}}
{{--                        <li><a href="{{route("admin.table.products")}}" >Products</a></li>--}}
{{--                        <li><a href="{{route("admin.table.orders")}}">Orders</a></li>--}}
{{--                        <li><a href="{{route("admin.table.users")}}">Users</a></li>--}}
{{--                        <li><a href="{{route("admin.table.news")}}" >News</a></li>--}}
{{--                    </ul>--}}
                    <ul aria-expanded="false">
                        <li><a href="{{route("admin.table.products")}}">Product</a></li>
                        <li><a href="{{route("admin.table.orders")}}">Orders</a></li>
                        <li><a href="{{route("admin.table.users")}}">Users</a></li>
                        <li><a href="{{route("admin.table.news")}}">News</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="icon-note menu-icon"></i><span class="nav-text">Create</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route("admin.form.product")}}">Product</a></li>
                        <li><a href="{{route("admin.form.order")}}">Order</a></li>
                        <li><a href="{{route("admin.form.user")}}">User</a></li>
                        <li><a href="{{route("admin.form.new")}}">New</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--**********************************
        Sidebar end
    ***********************************-->

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">

     @yield("redirec")
        <!-- row -->

        <div class="container-fluid">
            @yield("body")
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->
</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<script src="../admin/plugins/common/common.min.js"></script>
<script src="../admin/js/custom.min.js"></script>
<script src="../admin/js/settings.js"></script>
<script src="../admin/js/gleek.js"></script>
<script src="../admin/js/styleSwitcher.js"></script>

@yield("script")
</body>

</html>