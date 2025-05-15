@extends('layouts.master')
@section('title', $product->name)

@section('content')
<div class="row mt-4">
  <div class="col-md-4">
    <img src="{{ asset("images/{$product->photo}") }}"
         class="img-fluid img-thumbnail"
         alt="{{ $product->name }}">
  </div>

  <div class="col-md-8">
    <h2>{{ $product->name }}</h2>
    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>In Stock:</strong> {{ $product->quantity }}</p>
    <p>{{ $product->description }}</p>

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @auth
      @if($product->quantity > 0)
        <form action="{{ route('cart.add', $product->id) }}"
              method="POST"
              class="d-flex gap-2 align-items-center mt-3">
          @csrf
          <input type="number"
                 name="quantity"
                 value="1"
                 min="1"
                 max="{{ $product->quantity }}"
                 class="form-control"
                 style="max-width: 80px;">
          <button class="btn btn-primary">Add to Cart</button>
        </form>
      @else
        <div class="text-danger mt-3">Out of stock.</div>
      @endif
    @else
      <p class="mt-3"><a href="{{ route('login') }}">Log in</a> to add this item to your cart.</p>
    @endauth
  </div>
</div>
@endsection
