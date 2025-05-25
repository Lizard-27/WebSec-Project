@extends('layouts.master')
@section('title', 'Add Role')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    /* ---------- Base ---------- */
    body, html {
        margin: 0; padding: 0;
        height: 100vh; width: 100vw;
        font-family: 'Inter', sans-serif;
        overflow: hidden;
    }

    a { text-decoration: none; }

    /* ---------- Layout ---------- */
    .split-screen {
        display: flex;
        height: 100vh; width: 100vw;
        position: fixed; top: 0; left: 0;
    }
    .left-half {
        flex: 1;
        background:
          linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0)),
          url('https://ik.imagekit.io/jyx7871cz/Restaurant,_Roppongi,_Tokyo,_Japan_1_(133461680).jpg')
            no-repeat center center;
        background-size: cover;
    }
    .right-half {
        width: 45%; min-width: 500px;
        background: #121212;
        display: flex; align-items: center; justify-content: center;
        padding: 2rem; overflow-y: auto;
    }

    /* ---------- Card ---------- */
    .role-card {
        width: 100%; max-width: 480px;
        background: #1e1e1e;
        border-radius: 0.75rem;
        box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        padding: 2.5rem 2rem;
        position: relative;
    }

    /* ---------- Back Button ---------- */
    .back-btn {
        position: absolute; top: 1.5rem; left: 1.5rem;
        background: #fff; color: #dc143c;
        border-radius: 50%; width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 8px rgba(220,20,60,0.2);
        font-size: 1.25rem;
        transition: background 0.2s;
    }
    .back-btn:hover { background: #f4f4f5; }

    /* ---------- Header ---------- */
    .role-header {
        text-align: center; margin-bottom: 2rem;
    }
    .role-header i {
        font-size: 3rem; color: #22c1c3;
        margin-bottom: 0.5rem;
    }
    .role-header h2 {
        color: #fff; font-size: 1.75rem; margin: 0.25rem 0;
    }
    .role-header p {
        color: #c0c0c0; font-size: 1rem;
    }

    /* ---------- Form ---------- */
    .form-label { color: #c0c0c0; font-weight: 500; }
    .form-control {
        background: #2a2a2a; color: #fff;
        border: 1px solid #3f3f46; border-radius: 0.5rem;
    }
    .form-control:focus {
        border-color: #22c1c3; box-shadow: none;
    }

    /* ---------- Permissions List ---------- */
    .permission-list {
        background: #2a2a2a;
        border: 1px solid #3f3f46;
        border-radius: 0.5rem;
        max-height: 300px;
        overflow-y: auto;
        padding: 1rem;
    }
    .permission-list .form-check {
        margin-bottom: 0.5rem;
    }
    .permission-list .form-check-label {
        color: #e5e7eb;
        margin-left: 0.5rem;
    }
    /* Custom checkbox color in modern browsers */
    .form-check-input {
        accent-color: #22c1c3;
    }

    /* ---------- Button ---------- */
    .btn-primary {
        background: #dc143c;
        border: none; border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600; width: 100%;
        transition: background 0.3s;
    }
    .btn-primary:hover {
        background: #b11236;
    }

    /* ---------- Alerts ---------- */
    .alert-success {
        background: rgba(34,193,195,0.1);
        color: #22c1c3; padding: 0.75rem 1rem;
        border-radius: 0.5rem; margin-bottom: 1.5rem;
    }
    .alert-danger {
        background: rgba(220,38,38,0.1);
        color: #f87171; padding: 0.75rem 1rem;
        border-radius: 0.5rem; margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
      .right-half { width: 100%; min-width: unset; }
      .role-card { padding: 1.5rem; }
    }
</style>

<div class="split-screen">
  <div class="left-half"></div>
  <div class="right-half">
    <div class="role-card">

      <!-- Back -->
      <a href="{{ route('profile', $user->id) }}" class="back-btn" title="Back to Profile">
        <i class="fas fa-arrow-left"></i>
      </a>

      <!-- Header -->
      <div class="role-header">
        <i class="fas fa-user-shield"></i>
        <h2>Add Role by {{ $user->name }}</h2>
        <p>Define a new role and assign permissions</p>
      </div>

      <!-- Success Message -->
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <!-- Form -->
      <form action="{{ route('users_add_role', $user->id) }}" method="POST">
        @csrf

        {{-- Role Name --}}
        <div class="mb-3">
          <label for="role_name" class="form-label">Role Name:</label>
          <input
            type="text"
            id="role_name"
            name="role_name"
            class="form-control @error('role_name') is-invalid @enderror"
            value="{{ old('role_name') }}"
            placeholder="e.g. moderator"
            required>
          @error('role_name')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        {{-- Permissions --}}
        <div class="mb-3">
          <label class="form-label">Permissions:</label>
          <div class="permission-list">
            @foreach($permissions as $perm)
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="permissions[]"
                  value="{{ $perm->name }}"
                  id="perm_{{ $perm->id }}"
                  {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm_{{ $perm->id }}">
                  {{ ucfirst($perm->name) }}
                </label>
              </div>
            @endforeach
          </div>
          @error('permissions')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="fas fa-plus-circle me-1"></i>
          Create Role
        </button>
      </form>
    </div>
  </div>
</div>

@endsection
