@extends('layouts.master')
@section('title', 'Dishes')
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
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px 0 30px 0;
    }
    .logo-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .logo-header img {
        width: 180px;
        height: 180px;
        object-fit: contain;
        margin-bottom: 1rem;
        filter: drop-shadow(0 6px 24px rgba(34,193,195,0.15));
    }
    .logo-header h1 {
        font-size: 2.7rem;
        font-weight: 800;
        letter-spacing: 2px;
        color: #22c1c3;
        text-shadow: 0 2px 12px rgba(34,193,195,0.12);
        margin-bottom: 0.2rem;
        text-align: center;
    }
    .logo-header p {
        font-size: 1.2rem;
        color: #fdba2d;
        font-weight: 600;
        margin-bottom: 0;
        letter-spacing: 1px;
    }
    .top-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .dish-row-card {
        background: #fff;
        border: 1.5px solid #22c1c344;
        border-radius: 1.1rem;
        box-shadow: 0 6px 24px 0 rgba(34,193,195,0.10);
        color: #1a2233;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: stretch;
        transition: box-shadow 0.2s;
        width: 100%;
        min-height: 180px;
    }
    .dish-row-card:hover {
        box-shadow: 0 10px 32px 0 rgba(34,193,195,0.18);
    }
    .dish-img {
        border-top-left-radius: 1.1rem;
        border-bottom-left-radius: 1.1rem;
        background: #e0fcff;
        object-fit: cover;
        width: 140px;
        height: 140px;
        min-width: 140px;
        min-height: 140px;
        max-width: 140px;
        max-height: 140px;
        margin: 20px 0 20px 20px;
        box-shadow: 0 2px 8px 0 rgba(34,193,195,0.07);
    }
    .dish-card-body {
        flex: 1;
        padding: 1.2rem 1.5rem 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .card-title {
        color: #b11236;
        font-size: 1.5rem;
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
        color: #b11236;
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
    .form-control {
        background: #fff;
        border: 1.5px solid #22c1c344;
        border-radius: 0.5rem;
        color: #1a2233;
        font-size: 1.05rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #b11236;
        box-shadow: 0 0 0 3px rgba(34,193,195,0.13);
    }
    @media (max-width: 1100px) {
        .dishes-main-container {
            max-width: 98vw;
            padding: 10px 0 15px 0;
        }
        .dish-row-card {
            flex-direction: column;
            align-items: stretch;
        }
        .dish-img {
            width: 100%;
            height: 180px;
            border-radius: 1.1rem 1.1rem 0 0;
            margin: 0;
        }
        .dish-card-body {
            padding: 1.2rem 1rem 1rem 1rem;
        }
        .top-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="dishes-main-container">
    <div class="logo-header">
                  <img src="https://ik.imagekit.io/jyx7871cz/cropped_image.png" alt="Ramen Icon" width="64" height="64">
        <h1>HIRORAMEN</h1>
        <p>Don't try it once try it twice</p>
    </div>

    <div class="top-actions">
        @can('add_products')
            <a href="{{ route('products_create') }}" class="btn btn-success">Add Dish</a>
        @endcan
        @auth
            <a href="{{ route('my_purchases') }}" class="btn btn-info">My Orders</a>
        @endauth
    </div>

    <form class="mb-3">
      <div class="row gx-2">
        <div class="col-12 mb-2">
          <input name="keywords" type="text" class="form-control" placeholder="Search dishes…" value="{{ request('keywords') }}" />
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
      <div class="dish-row-card">
        <img 
          src="{{ Str::startsWith($product->photo, ['http://', 'https://']) ? $product->photo : asset('images/' . $product->photo) }}" 
          class="dish-img" 
          alt="{{ $product->name }}">
        <div class="dish-card-body">
          <div class="average-stars mb-2">
            @php $avg = round($product->averageRating(),1); @endphp
            @for($i=1; $i<=5; $i++)
              <span style="color: {{ $i <= $avg ? '#f5b301' : '#ddd' }};">★</span>
            @endfor
            <small>({{ $avg }})</small>
          </div>

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
                Order Now
              </a>
            @else
              <button class="btn btn-secondary mt-2" disabled>Out of Stock</button>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn btn-warning mt-2">
              Login to Order
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
                  <button class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Delete this dish?')">
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
