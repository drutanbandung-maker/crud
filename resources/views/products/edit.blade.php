@extends('layout')

@section('content')
<h2>Edit Product</h2>

<form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="price" class="form-control" value="{{ $product->price }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Current Image</label>
        <div class="mb-2">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width:150px">
            @else
                <div class="text-muted">No image</div>
            @endif
        </div>
        <label class="form-label">Change Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary btn-submit" data-loading-text="Memperbarui...">Perbarui</button>
</form>
@endsection

