@extends('layout.adminlayout')
@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">แก้ไขผู้ใช้</h2>

    {{-- ข้อความ error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ข้อความ success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มแก้ไขผู้ใช้ --}}
    <div class="card glass-card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->user_id) }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Firstname</label>
                        <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lastname</label>
                        <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> บันทึกผู้ใช้
                    </button>
                    <a href="{{ route('admin.userManagement') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> กลับ
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ฟอร์มรีเซ็ตรหัสผ่าน --}}
    <div class="card glass-card shadow-sm border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-semibold">รีเซ็ตรหัสผ่าน</h5>
            <form method="POST" action="{{ route('admin.users.resetPassword', $user->user_id) }}">
                @csrf
                <button type="submit" class="btn btn-warning" onclick="return confirm('คุณแน่ใจว่าจะรีเซ็ตรหัสผ่านผู้ใช้นี้?')">
                    <i class="bi bi-key-fill me-1"></i> รีเซ็ต
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Glassmorphism CSS --}}
@push('styles')
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(12px);
    border-radius: 12px;
}
</style>
@endpush
@endsection
