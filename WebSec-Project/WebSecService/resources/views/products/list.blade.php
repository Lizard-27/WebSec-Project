@extends('layouts.master')
@section('title', 'Products')
@section('content')

<!-- Success & Error Messages -->
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
      <a href="{{ route('products_edit') }}" class="btn btn-success w-100">Add Product</a>
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
            <strong>Price:</strong> ${{ number_format($product->price,2) }}
          </p>
          <p class="card-text mb-3">
            <strong>Stock:</strong>
            @if($product->quantity > 0)
              <span class="badge bg-success">{{ $product->quantity }}</span>
            @else
              <span class="badge bg-secondary">Out of Stock</span>
            @endif
          </p>

          <!-- Buy Button -->
          @auth
            @if($product->quantity > 0 && auth()->user()->credit >= $product->price)
              <a href="{{ route('products.show', $product->id) }}"
                 class="btn btn-primary mt-auto">
                Buy
              </a>
            @elseif($product->quantity > 0)
              <button class="btn btn-secondary mt-auto" disabled>
                Insufficient Credit
              </button>
            @else
              <button class="btn btn-secondary mt-auto" disabled>
                Out of Stock
              </button>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-warning mt-auto">
              Login to Buy
            </a>
          @endauth
        </div>
      </div>
    </div>
  @endforeach
</div>

@endsection
