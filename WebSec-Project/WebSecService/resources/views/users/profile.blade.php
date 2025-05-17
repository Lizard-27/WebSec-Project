@extends('layouts.master')
@section('title', 'User Profile')
@section('content')
    <div class="row">
        <div class="m-4 col-sm-6">
            <table class="table table-striped">
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
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        @foreach ($permissions as $permission)
                            <span class="badge bg-success">{{ $permission->display_name }}</span>
                        @endforeach
                    </td>
                </tr>
            </table>

            <div class="row">
                <div class="col col-6">
                </div>
                @if (auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
                    <div class="d-grid gap-2 d-md-block">
                        <a class="btn btn-primary" href='{{ route('edit_password', $user->id) }}'>Change Password</a>
                        <a class="btn btn-primary" href='{{ route('users_add_role', $user->id) }}'>Add Role</a>
                    </div>
                @else
                    <div class="col col-4">
                    </div>
                @endif
                @if (auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
                    <div class="mt-2">
                        <a href="{{ route('users_edit', $user->id) }}" class="btn btn-danger  form-control ">Edit</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
