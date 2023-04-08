
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('product-datatable') }}"> Back</a>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>Name</label>
        <input type="text" name="name" value="{{ $product->name }}">
        <label>Price</label>
        <input type="number" name="price" value="{{ $product->price }}">
        <label>Quantity</label>
        <input type="number" name="quantity" value="{{ $product->quantity }}">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

