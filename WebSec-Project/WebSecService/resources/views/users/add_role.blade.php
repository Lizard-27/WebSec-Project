@extends('layouts.master')
@section('title', 'Register')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100vw;
        font-family: 'Inter', sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0)),
            url('https://ik.imagekit.io/jyx7871cz/vector-image-asian-face-mustache-600nw-1155849241.jpg.webp') no-repeat center center;
        background-size: cover;
        color: #f4f4f5;
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
            url('https://ik.imagekit.io/jyx7871cz/Restaurant,_Roppongi,_Tokyo,_Japan_1_(133461680).jpg') no-repeat center center;
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

    .register-card {
        width: 100%;
        max-width: 480px;
        background: #18181b;
        border-radius: 0.7rem;
        box-shadow: 0 6px 24px 0 rgba(34,193,195,0.10);
        padding: 2.2rem 2rem;
        margin: 0 auto;
    }

    .register-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .register-header img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 0.7rem;
        border: 3px solid #22c1c3;
        background: #222;
    }

    .register-header h2 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .register-header p {
        color: #a1a1aa;
        font-size: 1.05rem;
        margin-bottom: 0;
    }

    .form-label {
        color: #a1a1aa;
        font-weight: 500;
    }

    .form-control {
        background: #222;
        color: #fff;
        border: 1px solid #3f3f46;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .form-control:focus {
        background: #222;
        color: #fff;
        border-color: #22c1c3;
        box-shadow: none;
    }

    .btn-primary {
        background: #dc143c;
        color: white;
        border: none;
        font-weight: bold;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        transition: background 0.3s;
        margin-top: 1rem;
        width: 100%;
    }

    .btn-primary:hover {
        background: #b11236;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    a {
        color: #6366f1;
    }

    a:hover {
        color: #fff;
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
        .register-card {
            padding: 1.2rem 0.5rem;
        }
        .btn-primary {
            width: 100%;
        }
    }
</style>

<div class="split-screen">
    <div class="left-half"></div>
    <div class="right-half">
        <!-- Back button -->
        <a href="{{ auth()->check() ? route('profile', auth()->user()->id) : route('login') }}" 
           style="position: absolute; top: 32px; left: 32px; z-index: 10; color: #dc143c; background: rgba(255,255,255,0.85); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 8px rgba(220,20,60,0.08); font-size: 1.5rem;"
           title="Back to Profile">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="register-card">
            <div class="register-header">
                <img src="https://ik.imagekit.io/jyx7871cz/vector-image-asian-face-mustache-600nw-1155849241.jpg.webp" alt="User Icon">
                <h2>Register</h2>
                <p>Create a new account</p>
            </div>
            <form action="{{ route('do_register') }}" method="post">
                {{ csrf_field() }}
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{ $error }}
                    </div>
                @endforeach
                <div class="mb-3">
                    <label for="code" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">Email:</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">Password Confirmation:</label>
                    <input type="password" class="form-control" placeholder="Confirmation"
                        name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
                <div class="text-center mt-2">
                    <a href="{{ route('login') }}" class="login-link">Already have an account?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
