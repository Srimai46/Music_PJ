@extends('layout.adminlayout')

@section('title', 'Profile')

@section('content')
<div class="card mx-auto shadow-sm" style="max-width: 500px; margin-top: 40px; margin-bottom: 40px; border-radius: 0.5rem;">
    <div class="card-body p-4">
        <h3 class="card-title mb-4 text-center">Edit Profile</h3>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Firstname</label>
                <input type="text" class="form-control form-control-sm" name="firstname" value="{{ old('firstname', $admin->firstname) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Lastname</label>
                <input type="text" class="form-control form-control-sm" name="lastname" value="{{ old('lastname', $admin->lastname) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control form-control-sm" name="username" value="{{ old('username', $admin->username) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $admin->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control form-control-sm" name="phone" value="{{ old('phone', $admin->phone) }}">
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control form-control-sm" name="current_password">
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control form-control-sm" name="new_password">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" class="form-control form-control-sm" name="new_password_confirmation">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Minimal card shadow + smooth edges */
    .card {
        border: none;
    }
    .alert {
        border-radius: 0.25rem;
    }
    /* Button hover effect */
    .btn-primary {
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3; /* สีเข้มขึ้นเวลาชี้ */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* shadow เล็ก ๆ */
        transform: translateY(-2px); /* ยกขึ้นเล็กน้อย */
    }
</style>
@endsection
