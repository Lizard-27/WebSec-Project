@extends('layouts.master')
@section('title', $product->name)

@section('content')
  <style>
    /* ★ Rating stars CSS */
    .stars {
      direction: rtl;
      display: inline-flex;
    }
    .stars input {
      display: none;
    }
    .stars label {
      font-size: 2rem;
      color: #ddd;
      cursor: pointer;
    }
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
      color: #f5b301;
    }
    .average-stars {
      font-size: 1.5rem;
      color: #f5b301;
    }
  </style>

  <div class="mb-3">
    <a href="{{ route('products_list') }}" class="btn btn-secondary">
      ← Back to Products
    </a>
  </div>

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

      {{-- ★ Rating Section --}}
      <h3>Rate this dish</h3>

      @auth
        <form action="{{ route('products.rate', $product) }}" method="POST" class="rating-form">
          @csrf
          <div class="stars">
            @for($i=5; $i>=1; $i--)
              <input type="radio" id="star-{{ $i }}" name="rating" value="{{ $i }}"
                     {{ old('rating', $userRating) == $i ? 'checked' : '' }} />
              <label for="star-{{ $i }}" title="{{ $i }} stars">★</label>
            @endfor
          </div>
          <button type="submit" class="btn btn-sm btn-primary mt-2">Submit Rating</button>
        </form>
      @else
        <p><a href="{{ route('login') }}">Log in</a> to rate this dish.</p>
      @endauth

      <h4 class="mt-4">Average Rating:</h4>
      <div class="average-stars">
        @php
          $full  = floor($avg);
          $half  = $avg - $full >= 0.5;
          $empty = 5 - $full - ($half ? 1 : 0);
        @endphp

        @for($i = 0; $i < $full;  $i++) ★ @endfor
        @if($half) ☆ @endif
        @for($i = 0; $i < $empty; $i++) ☆ @endfor

        <span>({{ number_format($avg, 1) }} / 5)</span>
      </div>
      {{-- ★ End Rating Section --}}

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
