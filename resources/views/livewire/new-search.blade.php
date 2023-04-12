<div class="row height d-flex justify-content-center align-items-center">
    <div class="col-lg-6" style="margin-top: 150px">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-search"></i>
                    </span>
            </div>
            <input wire:model="search" type="search" class="form-control" placeholder="Username" aria-label="Search.."
                   aria-describedby="basic-addon1">
        </div>
    </div>
    <!-- latest news -->
    <div  class="latest-news mt-150 mb-150">
        <div class="container">
            <div class="row">
                @foreach($news as $new)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-latest-news">
                            <a href="{{ route('detail-new',['id'=>$new['id']]) }}">
                                <div class="latest-news-bg"
                                     style="background: url('{{$new['thumbnail']}}');background-size: cover"></div>
                            </a>
                            <div class="news-text-box">
                                <h3><a href="{{ route('detail-new',['id'=>$new['id']]) }}">{{ $new['title'] }}.</a></h3>
                                <p class="blog-meta">
                                    <span class="author"><i class="fas fa-user"></i> {{ !is_null($new->user) ? $new->user->name : "Unknown" }}</span>
                                    <span class="date"><i class="fas fa-calendar"></i> {{$new->created_at}}</span>
                                </p>
                                <p class="excerpt">{{$new->description}}.</p>
                                <a href="{{ route('detail-new',['id'=>$new['id']]) }}" class="read-more-btn">read more
                                    <i class="fas fa-angle-right"></i></a>
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
</div>
    <!-- end latest news -->
