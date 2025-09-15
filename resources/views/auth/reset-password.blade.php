@extends('layout.guestlayout')

@section('title', 'Reset Password')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" 
         style="width: 100%; max-width: 450px; 
                background: rgba(255,255,255,0.65); 
                backdrop-filter: blur(12px); 
                border-radius: 16px;">

        <h2 class="text-center mb-4 fw-bold text-dark">Reset Password</h2>

        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3 shadow-sm rounded-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/reset-password">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold text-dark">New Password</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-0" id="password" name="password" placeholder="Enter new password">
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-semibold text-dark">Confirm Password</label>
                <div class="input-group input-group-sm shadow-sm">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-0" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm" style="height: 2.75rem;">
                <i class="bi bi-arrow-repeat me-1"></i> Reset Password
            </button>
        </form>

        <div class="mt-3 text-center">
            <a href="/login" class="text-decoration-none text-secondary small">Back to Login</a>
        </div>
    </div>
</div>
@endsection
