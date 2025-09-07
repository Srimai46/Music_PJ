@extends('layout.adminlayout')

@section('title', 'Edit Room')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">แก้ไขห้อง: {{ $room->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- แสดง Error แบบ alert --}}
    @if ($errors->any() && ! $errors->hasBag('instrumentRoom'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->room_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">ชื่อห้อง</label>
                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">ราคา/ชั่วโมง</label>
                        <input type="number" step="0.01" name="price_per_hour" class="form-control" value="{{ $room->price_per_hour }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">จำนวนคน</label>
                        <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">คำอธิบาย</label>
                        <input type="text" name="description" class="form-control" value="{{ $room->description }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">รูปภาพปัจจุบัน</label>
                        <div class="mt-2">
                            @if($room->image_url)
                                <img src="{{ asset('storage/' . $room->image_url) }}" width="150" class="img-thumbnail rounded mb-2">
                            @else
                                <span class="text-muted small">ไม่มีรูป</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">อัปโหลดรูปใหม่ (ถ้ามี)</label>
                        <input type="file" name="image_url" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                        <a href="{{ route('admin.rooms') }}" class="btn btn-outline-secondary">ยกเลิก</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
