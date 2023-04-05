@extends(".layouts.client.layout-another-page")
@section('title-hero')
    <p>FRESH ADN ORGANIC</p>
    <h1>404 - Not Found</h1>
@endsection
@section('content-page')
    <!-- error section -->
    <div class="full-height-section error-section">
        <div class="full-height-tablecell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="error-text">
                            <i class="far fa-sad-cry"></i>
                            <h1>Oops! Not Found.</h1>
                            <p>The page you requested for is not found.</p>
                            <a href="{{route('home.page1')}}" class="boxed-btn">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end error section -->
@endsection