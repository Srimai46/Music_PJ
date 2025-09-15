@extends('layout.adminlayout')

@section('title', 'Edit Room')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary"><i class="bi bi-pencil-square me-1"></i> แก้ไขห้อง: {{ $room->name }}</h2>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ข้อความ error --}}
    @if ($errors->any() && ! $errors->hasBag('instrumentRoom'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle me-1"></i> {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card glass-card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.rooms.update', $room->room_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><i class="bi bi-house-door me-1"></i> ชื่อห้อง</label>
                        <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-cash-stack me-1"></i> ราคา/ชั่วโมง</label>
                        <input type="number" step="0.01" name="price_per_hour" class="form-control" value="{{ $room->price_per_hour }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold"><i class="bi bi-people me-1"></i> จำนวนคน</label>
                        <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold"><i class="bi bi-card-text me-1"></i> คำอธิบาย</label>
                        <input type="text" name="description" class="form-control" value="{{ $room->description }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold"><i class="bi bi-image me-1"></i> รูปภาพปัจจุบัน</label>
                        <div class="mt-2">
                            @if($room->image_url)
                                <img src="{{ asset('storage/' . $room->image_url) }}" width="150" class="img-thumbnail rounded mb-2">
                            @else
                                <span class="text-muted small">ไม่มีรูป</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold"><i class="bi bi-upload me-1"></i> อัปโหลดรูปใหม่ (ถ้ามี)</label>
                        <input type="file" name="image_url" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> บันทึกการแก้ไข</button>
                        <a href="{{ route('admin.rooms') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i> ยกเลิก</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Glassmorphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        transition: all 0.2s ease-in-out;
    }
    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endpush
@endsection
