@extends('layout.adminlayout')
@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Edit User</h2>

    {{-- ข้อความ error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ข้อความ success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ฟอร์มแก้ไขผู้ใช้ --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->user_id) }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Firstname</label>
                        <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lastname</label>
                        <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('admin.userManagement') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

    {{-- ฟอร์มรีเซ็ตรหัสผ่าน --}}
    <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Reset Password</h5>
            <form method="POST" action="{{ route('admin.users.resetPassword', $user->user_id) }}">
                @csrf
                <button type="submit" class="btn btn-warning"
                    onclick="return confirm('Are you sure you want to reset this user password?')">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
