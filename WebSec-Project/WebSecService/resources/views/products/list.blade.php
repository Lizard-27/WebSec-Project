@extends('layouts.master')
@section('title', 'Products')
@section('content')
<style>
    body {
        min-height: 100vh;
        background:
            linear-gradient(rgba(220,20,60,0.07), rgba(220,20,60,0.07)),
            url('https://ik.imagekit.io/jyx7871cz/2149013658.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #222;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .products-main-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px 0 30px 0;
    }
    h1 {
        font-size: 2.4rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        color: #dc143c;
        text-shadow: 0 2px 8px rgba(220,20,60,0.08);
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .top-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .product-row-card {
        background: #fff;
        border: 1.5px solid #dc143c33;
        border-radius: 1.1rem;
        box-shadow: 0 6px 24px 0 rgba(220,20,60,0.10);
        color: #222;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: stretch;
        transition: box-shadow 0.2s;
        width: 100%;
        min-height: 180px;
    }
    .product-row-card:hover {
        box-shadow: 0 10px 32px 0 rgba(220,20,60,0.18);
    }
    .product-img {
        border-top-left-radius: 1.1rem;
        border-bottom-left-radius: 1.1rem;
        background: #fff0f3;
        object-fit: cover;
        width: 260px;
        height: 100%;
        min-height: 180px;
        max-height: 220px;
    }
    .product-card-body {
        flex: 1;
        padding: 1.2rem 1.5rem 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .card-title {
        color: #dc143c;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.7rem;
        letter-spacing: 0.2px;
    }
    .card-text strong {
        color: #b11236;
        font-weight: 600;
    }
    .badge.bg-success, .badge.bg-secondary {
        font-size: 1rem;
        padding: 0.4em 0.8em;
        border-radius: 0.7em;
    }
    .badge.bg-success {
        background: #dc143c !important;
        color: #fff !important;
    }
    .badge.bg-secondary {
        background: #f3f4f6 !important;
        color: #dc143c !important;
        border: 1px solid #dc143c33;
    }
    .btn, .btn-primary, .btn-success, .btn-info, .btn-warning, .btn-outline-success, .btn-outline-danger, .btn-secondary {
        border-radius: 2rem !important;
        font-weight: 600;
        font-size: 1.07rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 12px 0 rgba(220,20,60,0.10);
        transition: none;
    }
    .btn-primary, .btn-success, .btn-info {
        background: linear-gradient(90deg, #dc143c 0%, #b11236 100%);
        color: #fff;
        border: none;
    }
    .btn-primary:hover, .btn-success:hover, .btn-info:hover {
        filter: brightness(1.08);
    }
    .btn-outline-success, .btn-outline-danger {
        background: transparent;
        color: #dc143c;
        border: 1.5px solid #dc143c;
    }
    .btn-outline-success:hover, .btn-outline-danger:hover {
        background: #dc143c;
        color: #fff;
    }
    .btn-warning {
        background: #fff0f3;
        color: #dc143c;
        border: 1.5px solid #dc143c33;
    }
    .btn-secondary {
        background: #f3f4f6;
        color: #dc143c;
        border: 1.5px solid #dc143c33;
    }
    .alert-success, .alert-danger {
        border-radius: 0.7rem;
        font-size: 1.05rem;
        margin-bottom: 1.2rem;
        padding: 0.9rem 1.2rem;
        border: none;
        box-shadow: 0 2px 8px 0 rgba(220,20,60,0.10);
    }
    .alert-success {
        background: rgba(220,20,60,0.07);
        color: #22c55e;
    }
    .alert-danger {
        background: rgba(220,38,38,0.13);
        color: #dc143c;
    }
    .form-control {
        background: #fff;
        border: 1.5px solid #dc143c33;
        border-radius: 0.5rem;
        color: #222;
        font-size: 1.05rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #dc143c;
        box-shadow: 0 0 0 3px rgba(220,20,60,0.13);
    }
    @media (max-width: 1100px) {
        .products-main-container {
            max-width: 98vw;
            padding: 10px 0 15px 0;
        }
        .product-row-card {
            flex-direction: column;
            align-items: stretch;
        }
        .product-img {
            width: 100%;
            height: 180px;
            border-radius: 1.1rem 1.1rem 0 0;
        }
        .product-card-body {
            padding: 1.2rem 1rem 1rem 1rem;
        }
        .top-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="products-main-container">
    <h1>Products</h1>

    <div class="top-actions">
        @can('add_products')
            <a href="{{ route('products_create') }}" class="btn btn-success">Add Product</a>
        @endcan
        @auth
            <a href="{{ route('my_purchases') }}" class="btn btn-info">My Purchases</a>
        @endauth
    </div>

    <form class="mb-3">
      <div class="row gx-2">
        <div class="col-12 mb-2">
          <input name="keywords" type="text" class="form-control" placeholder="Search…" value="{{ request('keywords') }}" />
        </div>
        <div class="col-6 mb-2">
          <input name="min_price" type="number" class="form-control" placeholder="Min $" value="{{ request('min_price') }}"/>
        </div>
        <div class="col-6 mb-2">
          <input name="max_price" type="number" class="form-control" placeholder="Max $" value="{{ request('max_price') }}"/>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
      </div>
    </form>

    @foreach($products as $product)
      <div class="product-row-card">
        <img src="{{ asset("images/{$product->photo}") }}"
             class="product-img"
             alt="{{ $product->name }}">
        <div class="product-card-body">
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
    @endforeach
</div>
@endsection
