@extends('layouts.app')
@section('Product-form', 'Create products')
@section('form')
    <h1>Welcome to my homepage2!</h1>
    <form method="POST" action="{{ route('edit', $product->id) }}" enctype="multipart/form-data">

        @csrf
        @method('PUT')
        <label>Name</label>
        <input type="text" name="name" value="{{ $product->name }}">
        <label>Price</label>
        <input type="number" name="price" value="{{ $product->price }}">
        <label>Quantity</label>
        <input type="number" name="quantity" value="{{ $product->quantity }}">
        <button type="submit">Update</button>
    </form>
@endsection
