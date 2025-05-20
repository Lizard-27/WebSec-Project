@extends('layouts.master')
@section('title', 'Products')
@section('content')

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row mt-2 mb-3">
  <div class="col-8"><h1>Products</h1></div>
  @auth
    <div class="col-2">
      <a href="{{ route('my_purchases') }}" class="btn btn-info w-100">My Purchases</a>
    </div>
  @endauth
  <div class="col-2">
    @can('add_products')
      <a href="{{ route('products_create') }}" class="btn btn-success w-100">Add Product</a>
    @endcan
  </div>
</div>

<form class="mb-3">
  <div class="row gx-2">
    <div class="col-sm-3">
      <input name="keywords" type="text" class="form-control" placeholder="Search…" value="{{ request('keywords') }}" />
    </div>
    <div class="col-sm-2">
      <input name="min_price" type="number" class="form-control" placeholder="Min $" value="{{ request('min_price') }}"/>
    </div>
    <div class="col-sm-2">
      <input name="max_price" type="number" class="form-control" placeholder="Max $" value="{{ request('max_price') }}"/>
    </div>
    <div class="col-sm-2">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </div>
</form>


<div class="row g-3">
  @foreach($products as $product)
    <div class="col-md-4">
      <div class="card h-100">
        <img src="{{ asset("images/{$product->photo}") }}"
             class="card-img-top"
             alt="{{ $product->name }}"
             style="object-fit: cover; height: 180px;">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $product->name }}</h5>
          <p class="card-text mb-1">
            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
          </p>
          <p class="card-text mb-3">
            <strong>Stock:</strong>
            @if($product->quantity > 0)
              <span class="badge bg-success">{{ $product->quantity }}</span>
            @else
              <span class="badge bg-secondary">Out of Stock</span>
            @endif
          </p>

          {{-- Purchase / View Details --}}
          @auth
            @if($product->quantity > 0)
              <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary mt-2">
                Buy
              </a>
            @else
              <button class="btn btn-secondary mt-2" disabled>Out of Stock</button>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-warning mt-2">
              Login to Buy
            </a>
          @endauth

          {{-- Admin Controls --}}
          @canany(['edit_products', 'delete_products'])
            <div class="mt-3 d-flex gap-2">
              @can('edit_products')
                <a href="{{ route('products_edit', $product->id) }}" class="btn btn-outline-success btn-sm w-100">Edit</a>
              @endcan
              @can('delete_products')
                <form action="{{ route('products_delete', $product->id) }}" method="POST" class="w-100">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Delete this product?')">
                    Delete
                  </button>
                </form>
              @endcan
            </div>
          @endcanany

        </div>
      </div>
    </div>
  @endforeach
</div>

@endsection
