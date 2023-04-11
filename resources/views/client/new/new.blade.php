@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>News</title>
@endsection
@section('title-hero')
    <p>Organic Information</p>
    <h1>News Article</h1>
@endsection
@section('content-page')
    <!-- latest news -->
    <div class="latest-news mt-150 mb-150">
        <div class="container">
            <div class="row">
                @foreach($news as $new)
                <div class="col-lg-4 col-md-6">
                    <div class="single-latest-news">
                        <a href="{{ route('detail-new',['id'=>$new['id']]) }}">
                            <div class="latest-news-bg" style="background: url('{{$new['thumbnail']}}');background-size: cover"></div>
                        </a>
                        <div class="news-text-box">
                            <h3><a href="{{ route('detail-new',['id'=>$new['id']]) }}">{{ $new['title'] }}.</a></h3>
                            <p class="blog-meta">
                                <span class="author"><i class="fas fa-user"></i> {{ $new->user->name }}</span>
                                <span class="date"><i class="fas fa-calendar"></i> {{$new->created_at}}</span>
                            </p>
                            <p class="excerpt">{{$new->description}}.</p>
                            <a href="{{ route('detail-new',['id'=>$new['id']]) }}" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <div class="pagination-wrap">
                                @include('client.pagination.default', ['paginator' => $news])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end latest news -->
@endsection