@extends('layouts.master')
@section('title', 'Users')
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
        color:rgb(255, 255, 255);
        overflow-x: hidden;
    }

    .centered-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .users-card {
        width: 100%;
        max-width: 1700px;
        background: #18181b;
        border-radius: 0.7rem;
        box-shadow: 0 6px 24px 0 rgba(34,193,195,0.10);
        padding: 2.2rem 2rem;
        margin: 0 auto;
    }

    .users-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .users-header img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 0.7rem;
        border: 3px solid #22c1c3;
        background: #222;
    }

    .users-header h1 {
        color: #fff;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .users-header p {
        color:rgb(255, 255, 255);
        font-size: 1.05rem;
        margin-bottom: 0;
    }

    .form-control, .btn {
        border-radius: 0.5rem;
        color: #fff;
    }

    .btn-primary {
        background: #dc143c;
        color: white;
        border: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background: #b11236;
    }

    .btn-danger {
        background: rgba(220, 38, 38, 0.2);
        color: #fca5a5;
        border: none;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-danger:hover {
        background: rgba(220, 38, 38, 0.3);
    }

    .table {
        background: transparent;
        color: #fff; /* Make all table text white */
        margin-top: 1.5rem;
    }

    .table th, .table td {
        background: transparent !important;
        border-bottom: 1px solid #3f3f46 !important;
        vertical-align: middle;
        color: #fff !important; /* Force table header and cell text to white */
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
        background-color: rgba(99, 102, 241, 0.2);
        color: #6366f1;
    }

    @media (max-width: 1200px) {
        .users-card {
            max-width: 98vw;
            padding: 1.2rem 0.5rem;
        }
        .table-responsive {
            overflow-x: auto;
        }
    }
    @media (max-width: 768px) {
        .users-card {
            padding: 1.2rem 0.5rem;
        }
        .users-header img {
            width: 60px;
            height: 60px;
        }
        .users-header h1 {
            font-size: 1.4rem;
        }
    }
</style>

<div class="centered-container">
    <div class="users-card">
        <div class="users-header">
            <img src="https://ik.imagekit.io/jyx7871cz/vector-image-asian-face-mustache-600nw-1155849241.jpg.webp" alt="Users Icon">
            <h1>Users</h1>
            <p>Manage all users in the system</p>
        </div>
        <form class="mb-3">
            <div class="row g-2 justify-content-center">
                <div class="col-sm-4">
                    <input name="keywords" type="text" class="form-control" placeholder="Search Keywords"
                        value="{{ request()->keywords }}" />
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-auto">
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td scope="col">{{ $user->id }}</td>
                        <td scope="col">{{ $user->name }}</td>
                        <td scope="col">{{ $user->email }}</td>
                        <td scope="col">
                            @foreach ($user->roles as $role)
                                <span class="badge">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td scope="col">
                            @can('edit_users')
                                <a class="btn btn-primary btn-sm" href='{{ route('users_edit', [$user->id]) }}'>Edit</a>
                            @endcan
                            @can('admin_users')
                                <a class="btn btn-primary btn-sm" href='{{ route('edit_password', [$user->id]) }}'>Change Password</a>
                            @endcan
                            @can('delete_users')
                                <a class="btn btn-danger btn-sm" href='{{ route('users_delete', [$user->id]) }}'>Delete</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
