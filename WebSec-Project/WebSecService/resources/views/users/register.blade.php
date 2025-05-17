@extends('layouts.master')
@section('title', 'Register')
@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        overflow: hidden; /* Prevent scrolling */
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
            linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)),
            url('https://ik.imagekit.io/jyx7871cz/gradient_2.jpg?updatedAt=1747489283026') no-repeat center center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .left-content {
        max-width: 80%;
        text-align: center;
        z-index: 2;
    }
    
    .left-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .left-content p {
        font-size: 1.1rem;
        opacity: 0.9;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }
    
    .right-half {
        width: 45%;
        min-width: 500px;
        background: #0f0f0f;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        overflow-y: auto; /* Only allow scrolling inside form if needed */
        height: 100vh;
    }
    
    .register-card {
        width: 100%;
        max-width: 420px;
        padding: 20px 0;
    }
    
    .logo {
        text-align: center;
        margin-bottom: 2.5rem;
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
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }
    
    .btn {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background:rgb(22, 61, 160);
        color: white;
    }
    
    .btn-primary:hover {
        background:rgb(28, 83, 222);
    }
    
    .login-link {
        display: block;
        text-align: center;
        margin-top: 1.5rem;
        color: #a1a1aa;
        font-size: 0.9rem;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .login-link:hover {
        color: #e4e4e7;
        text-decoration: underline;
    }
    
    .alert-danger {
        background: rgba(220, 38, 38, 0.2);
        border: 1px solid rgba(220, 38, 38, 0.3);
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
            min-width: auto;
            height: 100vh;
        }
    }

    /* Prevent scrolling on the body */
    body.prevent-scroll {
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('prevent-scroll');
    });
</script>

<div class="split-screen">
    <div class="left-half">
        <div class="left-content">

        </div>
    </div>
    
    <div class="right-half">
        <div class="register-card">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#6366f1">
                    <path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.8L20 9v6l-8 4-8-4V9l8-4.2z"/>
                </svg>
                <h2>Create Account</h2>
            </div>
            
            <form action="{{ route('do_register') }}" method="post">
                {{ csrf_field() }}
                
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <strong>Error!</strong> {{ $error }}
                    </div>
                @endforeach
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Register</button>
                
                <a href="{{ route('login') }}" class="login-link">Already have an account? Sign in</a>
            </form>
        </div>
    </div>
</div>
@endsection