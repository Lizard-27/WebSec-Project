@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Inter', sans-serif;
        background-color: #0f0f0f;
        color: #f4f4f5;
    }

    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #18181b;
        border-radius: 0.5rem;
        border: 1px solid #3f3f46;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-header h2 {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .profile-table {
        width: 100%;
        margin-bottom: 2rem;
        border-collapse: separate;
        border-spacing: 0;
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
    }

    .profile-table td {
        color: #f4f4f5;
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
        background: rgb(18, 56, 152);
        color: white;
    }

    .btn-primary:hover {
        background: rgb(28, 83, 222);
    }

    .btn-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
    }

    .btn-danger:hover {
        background: rgba(220, 38, 38, 0.3);
    }

    @media (max-width: 768px) {
        .profile-container {
            margin: 1rem;
            padding: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h2>User Profile</h2>
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
@endsection