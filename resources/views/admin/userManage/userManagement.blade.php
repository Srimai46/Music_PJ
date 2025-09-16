@extends('layout.adminlayout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold text-primary">จัดการบัญชีผู้ใช้</h1>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
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

                            {{-- Form รีเซ็ตรหัสผ่าน --}}
                            <form class="reset-password-form m-0" action="{{ route('admin.users.resetPassword', $user->user_id) }}" method="POST">
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

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // SweetAlert สำหรับรีเซ็ตรหัสผ่าน
    document.querySelectorAll('.reset-password-form').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: 'ยืนยันการรีเซ็ตรหัสผ่าน',
                text: 'คุณแน่ใจว่าจะรีเซ็ตรหัสผ่านผู้ใช้รายนี้?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'รีเซ็ต',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
@endsection
