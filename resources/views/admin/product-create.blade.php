@extends('layouts.app')
@section('Product-form', 'store products')
@section('form')
<form method="GET" action="{{ route('admin.product-store') }}" enctype="multipart/form-data">
    @csrf
    <label>Name</label>
    <input type="text" name="name" value="{{ $product->name }}">
    <label>Price</label>
    <input type="number" name="price" value="{{ $product->price }}">
    <label>Quantity</label>
    <input type="number" name="quantity" value="{{ $product->quantity }}">
    <input type="number" name="status" value="{{ $product->status }}">
    <button type="submit">Add Product</button>
</form>
@endsection
