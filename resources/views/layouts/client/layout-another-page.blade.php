@extends("layouts.client.layout-home")
@section('title')
    <!-- title -->
    @yield('title-page')
@endsection
@section('css')
    @yield('home-css')
@endsection
@section('body')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                    @yield('title-hero')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    @yield('content-page')
@endsection
@section('javascript')
    @yield('home-javascript')
@endsection