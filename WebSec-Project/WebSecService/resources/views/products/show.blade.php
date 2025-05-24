@extends('layouts.master')
@section('title', $product->name)

@section('content')
  <style>
    body {
        min-height: 100vh;
        background:
            linear-gradient(rgba(34,193,195,0.10), rgba(253,187,45,0.10)),
            url('https://ik.imagekit.io/jyx7871cz/2149013723.jpg?updatedAt=1747749116225') no-repeat center center fixed;
        background-size: cover;
        color: #1a2233;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .dishes-main-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 0 30px 0;
    }
    .logo-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .logo-header img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        margin-bottom: 1rem;
        filter: drop-shadow(0 6px 24px rgba(34,193,195,0.15));
    }
    .logo-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: 2px;
        color: #22c1c3;
        text-shadow: 0 2px 12px rgba(34,193,195,0.12);
        margin-bottom: 0.2rem;
        text-align: center;
    }
    .logo-header p {
        font-size: 1.1rem;
        color: #fdba2d;
        font-weight: 600;
        margin-bottom: 0;
        letter-spacing: 1px;
    }
    .btn, .btn-primary, .btn-success, .btn-info, .btn-warning, .btn-outline-success, .btn-outline-danger, .btn-secondary {
        border-radius: 2rem !important;
        font-weight: 600;
        font-size: 1.07rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 12px 0 rgba(34,193,195,0.10);
        transition: none;
    }
    .btn-primary, .btn-success, .btn-info {
        background: linear-gradient(90deg, #b11236 0%,rgb(220, 118, 138) 100%);
        color: #fff;
        border: none;
    }
    .btn-primary:hover, .btn-success:hover, .btn-info:hover {
        filter: brightness(1.08);
    }
    .btn-outline-success, .btn-outline-danger {
        background: transparent;
        color: #b11236;
        border: 1.5px solid #b11236;
    }
    .btn-outline-success:hover, .btn-outline-danger:hover {
        background: #b11236;
        color: #fff;
    }
    .btn-warning {
        background: #e0fcff;
        color: #b11236;
        border: 1.5px solid #22c1c344;
    }
    .btn-secondary {
        background: #f3f4f6;
        color: #22c1c3;
        border: 1.5px solid #22c1c344;
    }
    .alert-success, .alert-danger {
        border-radius: 0.7rem;
        font-size: 1.05rem;
        margin-bottom: 1.2rem;
        padding: 0.9rem 1.2rem;
        border: none;
        box-shadow: 0 2px 8px 0 rgba(34,193,195,0.10);
    }
    .alert-success {
        background: rgba(34,193,195,0.07);
        color: #22c55e;
    }
    .alert-danger {
        background: rgba(253,187,45,0.13);
        color: #fdba2d;
    }
    .product-detail-card {
        background: #fff;
        border: 1.5px solid #22c1c344;
        border-radius: 1.1rem;
        box-shadow: 0 6px 24px 0 rgba(34,193,195,0.10);
        color: #1a2233;
        margin-bottom: 1.2rem;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
        min-height: 220px;
        padding: 0;
    }
    .product-img {
        border-top-left-radius: 1.1rem;
        border-bottom-left-radius: 1.1rem;
        background: #e0fcff;
        object-fit: cover;
        width: 260px;
        height: 260px;
        min-width: 260px;
        min-height: 260px;
        max-width: 260px;
        max-height: 260px;
        margin: 30px 0 30px 30px;
        box-shadow: 0 2px 8px 0 rgba(34,193,195,0.07);
    }
    .product-card-body {
        flex: 1;
        padding: 2.2rem 2.2rem 2rem 2.2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .card-title {
        color: #22c1c3;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.7rem;
        letter-spacing: 0.2px;
    }
    .card-text strong {
        color: #fdba2d;
        font-weight: 600;
    }
    .badge.bg-success, .badge.bg-secondary {
        font-size: 1rem;
        padding: 0.4em 0.8em;
        border-radius: 0.7em;
    }
    .badge.bg-success {
        background: #b11236 !important;
        color: #fff !important;
    }
    .badge.bg-secondary {
        background: #f3f4f6 !important;
        color: #dc143c !important;
        border: 1px solid #dc143c;
    }
    .average-stars {
        font-size: 1.5rem;
        color: #f5b301;
        margin-bottom: 0.5rem;
    }
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
    .rating-form {
        margin-bottom: 0.5rem;
    }
    @media (max-width: 1100px) {
        .dishes-main-container {
            max-width: 98vw;
            padding: 10px 0 15px 0;
        }
        .product-detail-card {
            flex-direction: column;
            align-items: stretch;
        }
        .product-img {
            width: 100%;
            height: 220px;
            border-radius: 1.1rem 1.1rem 0 0;
            margin: 0;
        }
        .product-card-body {
            padding: 1.2rem 1rem 1rem 1rem;
        }
    }
  </style>

  <div class="dishes-main-container">
    <div class="logo-header">
        <img src="https://cdn-icons-png.flaticon.com/512/2718/2718224.png" alt="Ramen Icon">
        <h1>{{ $product->name }}</h1>
        <p>Discover &amp; order your favorite meals</p>
    </div>

    <div class="mb-3">
      <a href="{{ route('products_list') }}" class="btn btn-secondary">
        ← Back to Dishes
      </a>
    </div>

    <div class="product-detail-card">
      <img src="{{ asset("images/{$product->photo}") }}"
           class="product-img"
           alt="{{ $product->name }}">
      <div class="product-card-body">
        <div class="average-stars mb-2">
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

        <h2 class="card-title">{{ $product->name }}</h2>
        <p class="card-text mb-1">
          <strong>Price:</strong> ${{ number_format($product->price, 2) }}
        </p>
        <p class="card-text mb-1">
          <strong>In Stock:</strong>
          @if($product->quantity > 0)
            <span class="badge bg-success">{{ $product->quantity }}</span>
          @else
            <span class="badge bg-secondary">Out of Stock</span>
          @endif
        </p>
        <p class="card-text mb-3">{{ $product->description }}</p>

        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ★ Rating Section --}}
        <h4>Rate this dish</h4>
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

        {{-- Admin Controls --}}
        @canany(['edit_products', 'delete_products'])
          <div class="mt-4 d-flex gap-2">
            @can('edit_products')
              <a href="{{ route('products_edit', $product->id) }}" class="btn btn-outline-success btn-sm w-100">Edit</a>
            @endcan
            @can('delete_products')
              <form action="{{ route('products_delete', $product->id) }}" method="POST" class="w-100">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Delete this dish?')">
                  Delete
                </button>
              </form>
            @endcan
          </div>
        @endcanany

      </div>
    </div>
  </div>
@endsection 
