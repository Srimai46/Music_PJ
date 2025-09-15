@extends('layout.adminlayout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold text-primary">จัดการบัญชีผู้ใช้</h1>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ตารางผู้ใช้ --}}
    <div class="table-responsive">
        <table class="table align-middle text-center mb-0" style="background: rgba(255,255,255,0.6); backdrop-filter: blur(12px); border-radius: 12px;">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th class="text-start">ชื่อผู้ใช้</th>
                    <th class="text-start">อีเมล</th>
                    <th>เบอร์โทร</th>
                    <th>Role</th>
                    <th class="text-center">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td class="text-start fw-semibold">{{ $user->username }}</td>
                    <td class="text-start">{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('admin.editUser', $user->user_id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="แก้ไขผู้ใช้">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.users.resetPassword', $user->user_id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจว่าจะรีเซ็ตรหัสผ่าน?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="รีเซ็ตรหัสผ่าน">
                                    <i class="bi bi-key-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Initialize Bootstrap tooltip --}}
@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
