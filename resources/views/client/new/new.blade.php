@extends(".layouts.client.layout-another-page")
@section('title-page')
    <title>News</title>
@endsection
@section('title-hero')
    <p>Organic Information</p>
    <h1>News Article</h1>
@endsection
@section("home-css")
    <livewire:styles/>
@endsection
@section('content-page')
        <livewire:new-search/>
@endsection
@section("home-javascript")
    <livewire:scripts/>
@endsection
