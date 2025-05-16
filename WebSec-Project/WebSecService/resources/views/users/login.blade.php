@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-sm-6">
            <div class="card-body">
                <form action="{{ route('do_login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {{ $error }}
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group mb-2">
                        <label for="model" class="form-label">Email:</label>
                        <input type="email" class="form-control" placeholder="email" name="email" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="model" class="form-label">Password:</label>
                        <input type="password" class="form-control" placeholder="password" name="password" required>
                    </div>


                    {{-- <div class="mt-3 text-center">
  <a href="{{ route('auth.twitter') }}" class="btn btn-info">
    Login with Twitter
  </a>
</div>
<a href="{{ route('auth.github') }}" class="btn btn-dark">
  <i class="fab fa-github"></i> Login with GitHub
</a>

      <div class="mb-3 text-center">
        <a href="{{ route('auth.google') }}" class="btn btn-danger">Login with Google</a>
      </div> --}}

                    <div class="d-grid gap-2 d-md-flex text-center justify-content-md-end mt-5">
                        <a href="{{ route('auth.twitter') }}" class="btn btn-info me-4">
                            Login with Twitter
                        </a>
                        <a href="{{ route('auth.github') }}" class="btn btn-dark me-5">
                            <i class="fab fa-github"></i> Login with GitHub
                        </a>
                        <a href="{{ route('auth.google') }}" class="btn btn-danger me-4">
                            Login with Google
                        </a>
                        <a href="{{ route('redirectToFacebook') }}" class="btn btn-warning me-4">
                            Login with Facebook
                        </a>
                    </div>


                    <div class="form-group mb-2 mt-3 d-grid col-6 mx-auto">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
