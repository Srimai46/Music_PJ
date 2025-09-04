@extends('layout.adminlayout')

@section('title', 'Rooms Management')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">จัดการห้องซ้อม</h2>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ฟอร์มเพิ่มห้อง --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <input type="text" name="name" class="form-control" placeholder="ชื่อห้อง" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="price_per_hour" class="form-control" placeholder="ราคา/ชม." required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="capacity" class="form-control" placeholder="จำนวนคน" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="description" class="form-control" placeholder="คำอธิบาย">
                    </div>
                    <div class="col-md-2">
                        <input type="file" name="image_url" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-success">เพิ่ม</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ตารางห้อง --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>ชื่อห้อง</th>
                        <th>ราคา/ชม.</th>
                        <th>จำนวนคน</th>
                        <th>รายละเอียด</th>
                        <th>รูป</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td class="fw-semibold">{{ $room->name }}</td>
                        <td>{{ number_format($room->price_per_hour, 2) }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ $room->description }}</td>
                        <td>
                            @if($room->image_url)
                                <img src="{{ asset('storage/' . $room->image_url) }}" width="80" class="img-thumbnail rounded">
                            @else
                                <span class="text-muted small">ไม่มีรูป</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                                <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="btn btn-sm btn-outline-warning">แก้ไข</a>
                                <form action="{{ route('admin.rooms.delete', $room->room_id) }}" method="POST" class="m-0" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบห้องนี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
