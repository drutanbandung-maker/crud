@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Detail Produk</h2>
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Kembali</a>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary ms-1">Edit</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        @if($product->image)
            <div class="mb-3">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width:300px">
            </div>
        @endif
        <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
        <p class="card-text"><strong>Price:</strong> {{ number_format($product->price, 0, '.', ',') }}</p>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>

@endsection
