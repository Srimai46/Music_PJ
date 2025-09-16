@extends('layout.userlayout')

@section('title', 'Profile')

@section('content')
    <div class="mx-auto"
        style="max-width: 500px; margin: 40px auto; border-radius: 1rem; background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div class="p-4">
            <h3 class="text-center mb-4 fw-semibold">Edit Profile</h3>

            @if (session('success'))
                <div class="alert alert-success small rounded-2 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small rounded-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.profile.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium">Firstname</label>
                    <input type="text" class="form-control form-control-sm" name="firstname"
                        value="{{ old('firstname', $user->firstname) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Lastname</label>
                    <input type="text" class="form-control form-control-sm" name="lastname"
                        value="{{ old('lastname', $user->lastname) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Username</label>
                    <input type="text" class="form-control form-control-sm" name="username"
                        value="{{ old('username', $user->username) }}" readonly
                        style="background-color: #e9ecef; color: #6c757d;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email" class="form-control form-control-sm" name="email"
                        value="{{ old('email', $user->email) }}" readonly
                        style="background-color: #e9ecef; color: #6c757d;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Phone</label>
                    <input type="text" class="form-control form-control-sm" name="phone"
                        value="{{ old('phone', $user->phone) }}">
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-medium">Current Password</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">New Password</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Confirm New Password</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                        <input type="password" class="form-control" name="new_password_confirmation"
                            placeholder="Confirm New Password">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Minimal custom styles -->
    <style>
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .alert {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
    </style>
@endsection
