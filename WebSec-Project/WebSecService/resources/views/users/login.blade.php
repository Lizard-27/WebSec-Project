@extends('layouts.master')
@section('title', 'Login')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100vw;
        font-family: 'Inter', sans-serif;
        overflow: hidden;
    }

    .split-screen {
        display: flex;
        height: 100vh;
        width: 100vw;
        position: fixed;
        top: 0;
        left: 0;
    }

    .left-half {
        flex: 1;
        background:
            linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0)),
            url('https://ik.imagekit.io/jyx7871cz/2149013723(1).jpg') no-repeat center center;
        background-size: cover;
    }

    .right-half {
        width: 45%;
        min-width: 500px;
        background: #0f0f0f;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        overflow-y: auto;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        text-align: center;
    }

    .logo svg {
        width: 48px;
        height: 48px;
    }

    .logo h2 {
        margin-top: 1rem;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
    }

    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #a1a1aa;
    }

    .form-control {
        width: 100%;
        padding: 0.9rem 1.2rem;
        background: #18181b;
        border: 1px solid #3f3f46;
        border-radius: 0.5rem;
        color: #f4f4f5;
    }

    .btn-primary {
        width: 100%;
        padding: 1rem;
        border-radius: 0.5rem;
        background: #dc143c;
        color: white;
        border: none;
        font-weight: bold;
        margin-bottom: 1rem;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #b11236;
    }

    .social-buttons {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .social-btn {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: none;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .social-btn.twitter { background: #1da1f2; }
    .social-btn.github { background: #333; }
    .social-btn.google { background: #db4437; }
    .social-btn.facebook { background: #1877f2; }

    .social-btn:hover {
        opacity: 0.9;
    }

    .login-link {
        display: block;
        margin-top: 2rem;
        color: #a1a1aa;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .login-link:hover {
        color: #e4e4e7;
        text-decoration: underline;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .split-screen {
            flex-direction: column;
        }

        .left-half {
            display: none;
        }

        .right-half {
            width: 100%;
            min-width: 100%;
            height: 100vh;
        }
    }
</style>

<div class="split-screen">
    <div class="left-half"></div>

    <div class="right-half">
        <!-- Back button -->
        <a href="{{ route('welcome') }}" 
           style="position: absolute; top: 32px; left: 32px; z-index: 10; color: #dc143c; background: rgba(255,255,255,0.85); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 8px rgba(220,20,60,0.08); font-size: 1.5rem;"
           title="Back to Home">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="login-card">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#6366f1" viewBox="0 0 24 24"><path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.8L20 9v6l-8 4-8-4V9l8-4.2z"/></svg>
                <h2>Sign In</h2>
            </div>

            <form action="{{ route('do_login') }}" method="post">
                {{ csrf_field() }}

                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ $error }}
                    </div>
                @endforeach

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
                <div class="text-center mt-2">
                    @if (Route::has('password.request'))
                        <a class="login-link" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>
            </form>

            <div class="social-buttons">
                <a href="{{ route('auth.twitter') }}" class="social-btn twitter" title="Login with Twitter"><i class="fab fa-twitter"></i></a>
                <a href="{{ route('auth.github') }}" class="social-btn github" title="Login with GitHub"><i class="fab fa-github"></i></a>
                <a href="{{ route('auth.google') }}" class="social-btn google" title="Login with Google"><i class="fab fa-google"></i></a>
                <a href="{{ route('redirectToFacebook') }}" class="social-btn facebook" title="Login with Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>

            <a href="{{ route('register') }}" class="login-link">Don't have an account? Register</a>
        </div>
    </div>
</div>
@endsection