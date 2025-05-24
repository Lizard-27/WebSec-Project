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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            margin: 0;
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .header-wrapper {
            width: 90%;
            max-width: 1500px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .custom-header {
            background: rgba(24, 24, 27, 0.72);
            height: 56px;
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.5rem;
            box-shadow: 0 2px 16px 0 #b11236;
            margin-top: 1.5rem;
            backdrop-filter: blur(8px) saturate(120%);
            border: 1px solid #b11236;
            transition: background 0.3s;
            position: relative;
        }

        .custom-header .left,
        .custom-header .right {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            position: absolute;
            top: 0;
            height: 100%;
        }

        .custom-header .left {
            left: 1.5rem;
        }

        .custom-header .right {
            right: 1.5rem;
        }

        .custom-header .center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 56px;
            position: relative;
            margin: 0 auto;
            z-index: 1;
        }

        .custom-header .center img {
            height: 38px;
            width: auto;
            display: block;
            margin: 0 auto;
            filter: drop-shadow(0 2px 8px #b11236);
            user-select: none;
        }

        .custom-header a {
            color: #f4f4f5;
            text-decoration: none;
            font-size: 1.08rem;
            font-weight: 500;
            padding: 0.2rem 0.7rem;
            border-radius: 1.2rem;
            transition: background 0.18s, color 0.18s;
            opacity: 0.92;
        }

        .custom-header a:hover {
            background: rgba(34, 193, 195, 0.13);
            color: #dc143c;
        }

        .custom-header i {
            font-size: 1.32rem;
            vertical-align: middle;
        }

        .custom-header .badge {
            font-size: 0.85rem;
            padding: 0.2em 0.5em;
            border-radius: 1em;
            background: #fdba2d !important;
            color: #18181b !important;
            box-shadow: 0 2px 8px 0 rgba(34, 193, 195, 0.10);
        }

        @media (max-width: 900px) {
            .custom-header {
                flex-direction: column;
                height: auto;
                padding: 1.2rem 1rem;
                gap: 0.7rem;
            }

            .custom-header .center {
                position: static;
                transform: none;
                margin: 0.5rem 0;
                justify-content: center;
            }
        }

        .container {
            margin-top: 3rem;
        }
    </style>
</head>

<body>

    @php
        $hideNavbar = false;
        $currentRoute = Route::currentRouteName();
        if (
            in_array($currentRoute, [
                'login',
                'do_login',
                'register',
                'do_register',
                'profile',
                'password.request',
                'password.email',
                'password.reset',
                'password.update',
                'edit_password',
                'users_add_role',
                'users_edit',
            ])
        ) {
            $hideNavbar = true;
        }
    @endphp

    @unless ($hideNavbar)
        <header class="header-wrapper">
            <div class="custom-header">

                <div class="left">
                    @auth
                        @if (auth()->user()->hasPermissionTo('can_finance'))
                            <a href="{{ route('finance') }}">Finance</a>
                        @else
                            @unless (auth()->user()->hasRole('Delivery'))
                                <a href="{{ route('products_list') }}">Products</a>
                            @endunless
                        @endif

                        @if (auth()->user()->hasRole('Delivery'))
                            <a href="{{ route('delivery.index') }}">Delivery Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('products_list') }}">Products</a>
                    @endauth
                </div>



                {{-- CENTER --}}
                <div class="center">
                    <a href="{{ route('welcome') }}">
                        <img src="https://ik.imagekit.io/jyx7871cz/cropped_image.png" alt="WebSec Logo" draggable="false">
                    </a>
                </div>

                {{-- RIGHT --}}
                <div class="right">
                    @auth
                        {{-- Delivery “pin” --}}
                        @if (auth()->user()->hasRole('Delivery'))
                            @php
                                $nextOrder = \DB::table('orders')
                                    ->where('delivery_confirmed', false)
                                    ->orderBy('created_at', 'asc')
                                    ->value('id');
                            @endphp
                            @if ($nextOrder)
                                <a href="{{ route('delivery.show', $nextOrder) }}" title="Track Next Order">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </a>
                            @endif

                            {{-- Customer “eye” --}}
                        @else
                            <a href="{{ route('my_purchases') }}" title="Track My Orders">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        @endif

                        {{-- Cart --}}
                        @php $count = auth()->user()->cart?->items->sum('quantity') ?? 0; @endphp
                        <a href="{{ route('cart.index') }}" title="Cart" class="position-relative">
                            <i class="bi bi-cart"></i>
                            @if ($count > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                                    {{ $count }}
                                    <span class="visually-hidden">cart items</span>
                                </span>
                            @endif
                        </a>

                        {{-- 👥 Show Users --}}
                        @can('show_users')
                            <a href="{{ route('users') }}" title="Manage Users">
                                <i class="bi bi-people-fill"></i>
                            </a>
                        @endcan

                        {{-- Profile & Logout --}}
                        <a href="{{ route('profile') }}" title="Profile"><i class="bi bi-person-circle"></i></a>
                        <a href="{{ route('do_logout') }}" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
                    @else
                        <a href="{{ route('register') }}" title="Register"><i class="bi bi-person-plus"></i></a>
                    @endauth
                </div>

            </div>
        </header>
    @endunless

    <div class="container">
        <h1>@yield('header')</h1>
        @yield('content')
    </div>

    <!-- Leaflet JS & Geocoder -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
