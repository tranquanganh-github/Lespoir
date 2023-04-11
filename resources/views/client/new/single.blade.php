@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>Detail New</title>
@endsection
@section('title-hero')
    <p>Read the Details</p>
    <h1>Single Article</h1>
@endsection
@section('content-page')

    <!-- single article section -->
    <div class="mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-article-section">
                        <div class="">
                            <div class="single-product-img">
                                <img src="{{$new['thumbnail']}}" alt="">
                            </div>
                            <p class="blog-meta">
                                <span class="author"><i class="fas fa-user"></i>@if($new['author_id'] === 1) Admin @endif</span>
                                <span class="date"><i class="fas fa-calendar"></i> 27 December, 2019</span>
                            </p>
                            <h2>{{ $new['title'] }}</h2>
                            <p>{{ $new['description'] }}</p>
                            <p>{!!$new['content']!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single article section -->

@endsection