@extends('layouts.master')
@section('title', 'User Profile')
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

    .profile-header .fa-user-circle {
        font-size: 3.5rem;
        color: #22c1c3;
        margin-bottom: 0.7rem;
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

    .profile-table {
        width: 100%;
        margin-bottom: 2rem;
        border-collapse: separate;
        border-spacing: 0;
        background: transparent;
    }

    .profile-table th, 
    .profile-table td {
        padding: 1rem;
        border-bottom: 1px solid #3f3f46;
        text-align: left;
    }

    .profile-table th {
        color: #a1a1aa;
        font-weight: 500;
        width: 30%;
        background: transparent;
    }

    .profile-table td {
        color: #f4f4f5;
        background: transparent;
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .badge-primary {
        background-color: rgba(99, 102, 241, 0.2);
        color: #6366f1;
    }

    .badge-success {
        background-color: rgba(22, 163, 74, 0.2);
        color: #16a34a;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
        justify-content: center;
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
    }

    .btn-primary {
        background: #dc143c;
        color: white;
    }

    .btn-primary:hover {
        background: #b11236;
    }

    .btn-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
    }

    .btn-danger:hover {
        background: rgba(220, 38, 38, 0.3);
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
        .action-buttons {
            flex-direction: column;
        }
        .btn {
            width: 100%;
        }
    }
</style>

<div class="split-screen">
    <div class="left-half"></div>
    <div class="right-half">
        <div class="profile-card">
            <div class="profile-header">
                <img 
                    src="https://ik.imagekit.io/jyx7871cz/vector-image-asian-face-mustache-600nw-1155849241.jpg.webp" 
                    alt="User Photo" 
                    style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 0.7rem; border: 3px solid #22c1c3; background: #222;"
                >
                <h2>{{ $user->name }}</h2>
                <p>User Profile</p>
            </div>

            <table class="profile-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge badge-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        @foreach ($permissions as $permission)
                            <span class="badge badge-success">{{ $permission->display_name }}</span>
                        @endforeach
                    </td>
                </tr>
            </table>

            <div class="action-buttons">
                @if (auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                    <a class="btn btn-primary" href='{{ route('edit_password', $user->id) }}'>Change Password</a>
                    <a class="btn btn-primary" href='{{ route('users_add_role', $user->id) }}'>Add Role</a>
                @endif
                
                @if (auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                    <a href="{{ route('users_edit', $user->id) }}" class="btn btn-danger">Edit Profile</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection