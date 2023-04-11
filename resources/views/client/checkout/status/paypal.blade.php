@extends(".layouts.client.layout-another-page")
@section('title-hero')
    <p>FRESH ADN ORGANIC</p>
<?php
$message_for_checkout = session()->get("message_for_checkout");
?>
    @if(!is_null($message_for_checkout))
        @switch($message_for_checkout)
            @case(\App\Http\Enum\Status::STATUS_SUCCESS)
            <h1>Payment Successful</h1>
            @break
            @case(\App\Http\Enum\Status::STATUS_FAIL)
            <h1>Payment Fail</h1>
            @break
        @endswitch
    @else
        <h1>404 - Not Found</h1>
    @endif
@endsection
@section('content-page')
    <!-- error section -->
    <div class="full-height-section error-section">
        <div class="full-height-tablecell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="error-text">
                            @if(!is_null($message_for_checkout))
                            @switch($message_for_checkout)
                                @case(\App\Http\Enum\Status::STATUS_SUCCESS)
                                <i class="far fa-smile-wink"></i>
                                <h1>Payment success.</h1>
                                <p>Congratulations! Your payment is successful.</p>
                                @break
                                @case(\App\Http\Enum\Status::STATUS_FAIL)
                                    <i class="far fa-hand-paper"></i>
                                    <h1>Oops! Payment Fail.</h1>
                                    <p>Your payment failed.</p>
                                @break
                            @endswitch
                            @else
                                <i class="far fa-sad-cry"></i>
                                <h1>Oops! Not Found.</h1>
                                <p>The page you requested for is not found.</p>
                            @endif
                            <a href="{{route('home.page1')}}" class="boxed-btn">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end error section -->
@endsection