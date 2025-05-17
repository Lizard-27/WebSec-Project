<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .header-wrapper {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .custom-header {
            background-color: #000000;
            height: 100px;
            border-bottom-left-radius: 200px;
            border-bottom-right-radius: 200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .custom-header .left,
        .custom-header .right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .custom-header .center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 28px;
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        .custom-header a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .custom-header a:hover {
            color: #fe5900;
        }

        .custom-header i {
            font-size: 1.4rem;
        }

        .container {
            margin-top: 3rem;
        }
    </style>
</head>

<body>

    <header class="header-wrapper mt-0">
        <div class="custom-header">
            <div class="left">
                <a href="{{ route('products_list') }}">Products</a>
            </div>

            <div class="center">
                Welcome
            </div>

            <div class="right">
                @auth
                    <a href="{{ route('profile') }}" title="Profile"><i class="bi bi-person-circle"></i></a>
                    <a href="{{ route('do_logout') }}" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
                @else
                    {{-- <a href="{{ route('login') }}" title="Login"><i class="bi bi-box-arrow-in-right"></i></a> --}}
                    <a href="{{ route('register') }}" title="Register"><i class="bi bi-person-plus"></i></a>
                @endauth
            </div>
        </div>
    </header>

    <div class="container">
        <h1>@yield('header')</h1>
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
