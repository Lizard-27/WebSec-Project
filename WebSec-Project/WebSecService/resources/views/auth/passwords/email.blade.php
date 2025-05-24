@extends('layouts.master')

@section('title', 'Forgot Password')

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

    .forgot-card {
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

    .alert-success {
        background: rgba(34,197,94,0.15);
        color: #4ade80;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-danger, .text-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5 !important;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        display: block;
        border: none;
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
        <div class="forgot-card">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#6366f1" viewBox="0 0 24 24"><path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.8L20 9v6l-8 4-8-4V9l8-4.2z"/></svg>
                <h2>Forgot Password</h2>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Send Password Reset Link
                </button>
            </form>

            <a href="{{ route('login') }}" class="login-link">Back to Login</a>
        </div>
    </div>
</div>
@endsection
