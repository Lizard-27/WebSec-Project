@extends('layouts.master')
@section('title', 'Edit User Password')
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
            url('https://ik.imagekit.io/jyx7871cz/2149013723(1).jpg') no-repeat center center;
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

    .profile-card {
        width: 100%;
        max-width: 480px;
        background: #18181b;
        border-radius: 0.7rem;
        box-shadow: 0 6px 24px 0 rgba(34,193,195,0.10);
        padding: 2.2rem 2rem;
        margin: 0 auto;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-header img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 0.7rem;
        border: 3px solid #22c1c3;
        background: #222;
    }

    .profile-header h2 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .profile-header p {
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

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        margin-top: 1rem;
        width: 100%;
    }

    .btn-secondary {
        background: #dc143c;
        color: white;
    }

    .btn-secondary:hover {
        background: #b11236;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
        border: none;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
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
        .profile-card {
            padding: 1.2rem 0.5rem;
        }
    }
</style>

<div class="split-screen">
    <div class="left-half"></div>
    <div class="right-half">
        <!-- Back button -->
        <a href="{{ route('profile', $user->id) }}" 
           style="position: absolute; top: 32px; left: 32px; z-index: 10; color: #dc143c; background: rgba(255,255,255,0.85); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 8px rgba(220,20,60,0.08); font-size: 1.5rem;"
           title="Back to Profile">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="profile-card">
            <div class="profile-header">
                <img src="https://ik.imagekit.io/jyx7871cz/vector-image-asian-face-mustache-600nw-1155849241.jpg.webp" alt="User Icon">
                <h2>{{ $user->name }}</h2>
                <p>Change Password</p>
            </div>
            <form action="{{route('save_password', $user->id)}}" method="post">
                {{ csrf_field() }}
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{$error}}
                </div>
                @endforeach

                @if(!auth()->user()->hasPermissionTo('admin_users') || auth()->id()==$user->id)
                    <div class="mb-3">
                        <label class="form-label">Old Password:</label>
                        <input type="password" class="form-control" placeholder="Old Password" name="old_password" required>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">New Password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password:</label>
                    <input type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
