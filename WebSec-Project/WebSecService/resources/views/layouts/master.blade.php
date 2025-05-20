<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Leaflet CSS (for your tracking maps) -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  />

  <style>
    body { margin: 0; background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .header-wrapper { width: 80%; max-width: 1200px; margin: 0 auto; position: relative; }
    .custom-header {
      background: #000; height: 100px; border-bottom-left-radius: 200px;
      border-bottom-right-radius: 200px; display: flex; justify-content: space-between;
      align-items: center; padding: 0 2rem; box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .custom-header .left, .custom-header .right {
      display: flex; align-items: center; gap: 1rem;
    }
    .custom-header .center {
      position: absolute; left: 50%; transform: translateX(-50%);
      top: 28px; color: #fff; font-size: 1.5rem; font-weight: 600;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
    }
    .custom-header a { color: #fff; text-decoration: none; font-size: 1.1rem; }
    .custom-header a:hover { color: #fe5900; }
    .custom-header i { font-size: 1.4rem; }
    .container { margin-top: 3rem; }
  </style>
</head>
<body>

  <header class="header-wrapper">
    <div class="custom-header">

      {{-- LEFT: Products link for everyone, Delivery Dashboard for delivery-role --}}
      <div class="left">
        @auth
          @unless(auth()->user()->hasRole('Delivery'))
            <a href="{{ route('products_list') }}">Products</a>
          @endunless

          @if(auth()->user()->hasRole('Delivery'))
            <a href="{{ route('delivery.index') }}">Delivery Dashboard</a>
          @endif
        @else
          <a href="{{ route('products_list') }}">Products</a>
        @endauth
      </div>

      {{-- CENTER --}}
      <div class="center">Welcome</div>

      {{-- RIGHT: geo‑pin for delivery → next order; eye for customers → their orders; cart; profile/logout --}}
      <div class="right">
        @auth
          {{-- Delivery “pin” to the next pending order --}}
          @if(auth()->user()->hasRole('Delivery'))
            @php
              $nextOrder = \DB::table('orders')
                              ->where('delivery_confirmed', false)
                              ->orderBy('created_at','asc')
                              ->value('id');
            @endphp

            @if($nextOrder)
              <a
                href="{{ route('delivery.show', $nextOrder) }}"
                title="Track Next Order"
              >
                <i class="bi bi-geo-alt-fill"></i>
              </a>
            @endif

          {{-- Customer “eye” to view their own purchases --}}
          @else
            <a
              href="{{ route('my_purchases') }}"
              title="Track My Orders"
            >
              <i class="bi bi-eye-fill"></i>
            </a>
          @endif

          {{-- Cart icon with badge --}}
          @php $count = auth()->user()->cart?->items->sum('quantity') ?? 0; @endphp
          <a href="{{ route('cart.index') }}" title="Cart" class="position-relative">
            <i class="bi bi-cart"></i>
            @if($count > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                {{ $count }}
                <span class="visually-hidden">cart items</span>
              </span>
            @endif
          </a>

          {{-- Profile & Logout --}}
          <a href="{{ route('profile') }}" title="Profile"><i class="bi bi-person-circle"></i></a>
          <a href="{{ route('do_logout') }}" title="Logout"><i class="bi bi-box-arrow-right"></i></a>

        @else
          {{-- Guest: Register --}}
          <a href="{{ route('register') }}" title="Register"><i class="bi bi-person-plus"></i></a>
        @endauth
      </div>

    </div>
  </header>

  <div class="container">
    <h1>@yield('header')</h1>
    @yield('content')
  </div>

  <!-- Leaflet JS & Geocoder (for on-page maps) -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
