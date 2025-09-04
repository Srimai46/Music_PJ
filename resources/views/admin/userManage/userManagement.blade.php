@extends('layout.adminlayout')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 fw-bold">จัดการบัญชีผู้ใช้</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>ชื่อผู้ใช้</th>
                    <th>อีเมล</th>
                    <th>เบอร์โทร</th>
                    <th>Role</th>
                    <th class="text-center">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.editUser', $user->user_id) }}" class="btn btn-primary btn-sm">
                                แก้ไข
                            </a>
                            <form action="{{ route('admin.users.resetPassword', $user->user_id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจว่าจะรีเซ็ตรหัสผ่าน?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    รีเซ็ตรหัสผ่าน
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
@endsection
