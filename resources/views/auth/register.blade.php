@extends('layout.guestlayout')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" 
         style="width: 100%; max-width: 450px; 
                background: rgba(255,255,255,0.65); 
                backdrop-filter: blur(12px); 
                border-radius: 16px;">

        <h2 class="text-center mb-4 fw-bold text-dark">Register</h2>

        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3 shadow-sm rounded-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="mb-3">
                <label for="firstname" class="form-label fw-semibold text-dark">Firstname</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control border-0" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Firstname">
                </div>
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label fw-semibold text-dark">Lastname</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control border-0" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Lastname">
                </div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold text-dark">Username</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-person-badge-fill"></i></span>
                    <input type="text" class="form-control border-0" id="username" name="username" value="{{ old('username') }}" placeholder="Username">
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold text-dark">Email</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" class="form-control border-0" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-semibold text-dark">Phone</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" class="form-control border-0" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-dark">Password</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password">
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold text-dark">Confirm Password</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-0" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm" style="height: 2.75rem;">
                <i class="bi bi-person-plus-fill me-1"></i> Register
            </button>
        </form>

        <div class="mt-3 text-center">
            <a href="/login" class="text-decoration-none text-secondary small">Already have an account? Login</a>
        </div>
    </div>
</div>
@endsection
