<<<<<<< HEAD
@extends('layouts')
@section('Product-form', 'store products')
@section('form')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('/') }}"> Back</a>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
=======
{{-- @extends('layouts.app') --}}
{{-- @section('Product-form', 'store products')
@section('form') --}}
<form method="GET" action="{{ route('store') }}" enctype="multipart/form-data">
>>>>>>> origin/dev
    @csrf
    <label>Name</label>
    <input type="text" name="name" value="{{ $product->name }}">
    <label>Price</label>
    <input type="number" name="price" value="{{ $product->price }}">
    <label>Quantity</label>
    <input type="number" name="quantity" value="{{ $product->quantity }}">
    <label>Status</label>
    <input type="number" name="status" value="{{ $product->status }}">
<<<<<<< HEAD
    <button type="submit" class="btn btn-primary">Add Product</button>
</form>
@endsection
=======
    <button type="submit">Add Product</button>
</form>
{{-- @endsection --}}
>>>>>>> origin/dev
