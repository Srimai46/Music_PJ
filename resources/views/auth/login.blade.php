@extends('layout.guestlayout')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" 
         style="width: 100%; max-width: 400px; 
                background: rgba(255,255,255,0.65); 
                backdrop-filter: blur(12px); 
                border-radius: 16px;">

        <h2 class="text-center mb-4 fw-bold text-dark">Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3 shadow-sm rounded-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="login" class="form-label fw-semibold text-dark">Username or Email</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control border-0" id="login" name="login" 
                           placeholder="Username or Email" value="{{ old('login') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-dark">Password</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 shadow-sm" style="height: 2.75rem;">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>

        <div class="mt-3 text-center">
            <a href="/register" class="text-decoration-none text-secondary small">Don't have an account? Register</a><br>
            <a href="/forgot-password" class="text-decoration-none text-secondary small">Forgot Password?</a>
        </div>
    </div>
</div>
@endsection
