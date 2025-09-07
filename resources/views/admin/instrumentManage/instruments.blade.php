@extends('layout.adminlayout')
@section('title', 'Instruments')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">
        🎼 เครื่องดนตรีในหมวด: <span class="text-dark">{{ $category->name }}</span>
    </h2>

    @if ($errors->any() && ! $errors->hasBag('instrumentRoom'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มเพิ่มเครื่องดนตรี --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.instruments.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->category_id }}">
                
                <div class="col-md-2">
                    <label class="form-label fw-semibold">รหัส</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">ชื่อเครื่องดนตรี</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">ยี่ห้อ</label>
                    <input type="text" name="brand" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">สถานะ</label>
                    <select name="status" class="form-select">
                        <option value="available">✅ ใช้ได้</option>
                        <option value="unavailable">❌ ใช้ไม่ได้</option>
                        <option value="maintenance">🛠️ ปรับปรุง</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">อัปโหลดรูป</label>
                    <input type="file" name="picture_url" class="form-control">
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-success">
                        + เพิ่ม
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- แสดง Grid ของเครื่องดนตรี --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($instruments as $instrument)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow-sm">
                    @if($instrument->picture_url)
                        <img src="{{ asset('storage/'.$instrument->picture_url) }}" class="card-img-top p-3" style="height:160px; object-fit:contain;">
                    @else
                        <div class="d-flex justify-content-center align-items-center" style="height:160px;">
                            <span class="fs-1">🎶</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $instrument->name }}</h5>
                        <p class="mb-1"><span class="fw-semibold">รหัส:</span> {{ $instrument->code }}</p>
                        <p class="mb-1"><span class="fw-semibold">ยี่ห้อ:</span> {{ $instrument->brand ?? '-' }}</p>
                        <p class="mb-0">
                            <span class="fw-semibold">สถานะ:</span>
                            @if($instrument->status == 'available')
                                <span class="badge bg-success">ใช้ได้</span>
                            @elseif($instrument->status == 'unavailable')
                                <span class="badge bg-danger">ใช้ไม่ได้</span>
                            @else
                                <span class="badge bg-warning text-dark">ปรับปรุง</span>
                            @endif
                        </p>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end flex-wrap gap-2">

                        <button class="btn btn-primary p-0 d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;"
                                data-bs-toggle="modal" data-bs-target="#editModal{{ $instrument->instrument_id }}" 
                                data-bs-toggle="tooltip" title="แก้ไข">
                            <i class="bi bi-pencil-fill fs-5"></i>
                        </button>

                        <button class="btn btn-info p-0 d-flex justify-content-center align-items-center"
                                style="width:40px; height:40px;"
                                data-bs-toggle="modal" data-bs-target="#roomsModal{{ $instrument->instrument_id}}"
                                data-bs-toggle="tooltip" title="ดูห้อง">
                            <i class="bi bi-house-fill fs-5"></i>
                        </button>

                        <form action="{{ route('admin.instruments.delete', $instrument->instrument_id) }}" method="POST" onsubmit="return confirm('ยืนยันการลบ?');" class="d-inline-flex m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger p-0 d-flex justify-content-center align-items-center"
                                    style="width:40px; height:40px;"
                                    data-bs-toggle="tooltip" title="ลบ">
                                <i class="bi bi-trash-fill fs-5"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Modal แก้ไข --}}
            <div class="modal fade" id="editModal{{ $instrument->instrument_id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md"> {{-- ขนาดกลาง --}}
                    <div class="modal-content border-0 shadow-sm rounded-4"> {{-- เงานุ่ม ๆ และมุมโค้ง --}}
                        <form action="{{ route('admin.instruments.update', $instrument->instrument_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                                <h5 class="modal-title fw-bold mb-0">แก้ไขเครื่องดนตรี</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">ชื่อเครื่องดนตรี</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $instrument->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">ยี่ห้อ</label>
                                    <input type="text" name="brand" class="form-control form-control-sm" value="{{ $instrument->brand }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">สถานะ</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="available" @if($instrument->status=='available') selected @endif>✅ ใช้ได้</option>
                                        <option value="unavailable" @if($instrument->status=='unavailable') selected @endif>❌ ใช้ไม่ได้</option>
                                        <option value="maintenance" @if($instrument->status=='maintenance') selected @endif>🛠️ ปรับปรุง</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">เปลี่ยนรูป</label>
                                    <input type="file" name="picture_url" class="form-control form-control-sm">
                                    @if($instrument->picture_url)
                                        <small class="text-muted d-block mt-1">ไฟล์ปัจจุบัน: {{ basename($instrument->picture_url) }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-footer border-0 pt-0 pb-3">
                                <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-save-fill"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">ยกเลิก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal ดูห้องที่ใช้เครื่องดนตรี --}}
            <div class="modal fade" id="roomsModal{{ $instrument->instrument_id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-sm rounded-4">
                        
                        <div class="modal-header bg-info text-white border-0 rounded-top-4">
                            <h5 class="modal-title fw-bold">ห้องที่ใช้: {{ $instrument->name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4">

                            {{-- ฟอร์มเพิ่มห้องให้เครื่องดนตรี --}}
                            <div class="card mb-4 shadow-sm rounded-3 border-0">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">➕ เพิ่มห้องให้เครื่องดนตรี</h6>
                                    <form action="{{ route('admin.instruments.storeRoom', $instrument->instrument_id) }}" method="POST" class="row g-3 align-items-end">
                                        @csrf
                                        <input type="hidden" name="instrument_id" value="{{ $instrument->instrument_id }}">

                                        <div class="col-md-6 position-relative">
                                            <label class="form-label fw-semibold">เลือกห้อง</label>
                                            <select name="room_id" class="form-select form-select-sm @error('room_id', 'instrumentRoom') is-invalid @enderror" required>
                                                @foreach(\App\Models\Room::all() as $room)
                                                    <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                                        {{ $room->name }} ({{ $room->capacity }} คน)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('room_id', 'instrumentRoom')
                                                <div class="invalid-feedback" style="position:absolute; bottom:-25px;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 position-relative">
                                            <label class="form-label fw-semibold">จำนวน</label>
                                            <input type="number" name="quantity" class="form-control form-control-sm @error('quantity', 'instrumentRoom') is-invalid @enderror" value="{{ old('quantity', 1) }}" min="1" required>
                                            @error('quantity', 'instrumentRoom')
                                                <div class="invalid-feedback" style="position:absolute; bottom:-25px;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3 d-grid">
                                            <button type="submit" class="btn btn-success btn-sm d-flex align-items-center justify-content-center gap-1">
                                                <i class="bi bi-plus-lg"></i> เพิ่ม
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- List ห้อง --}}
                            <div class="card mb-4 shadow-sm rounded-3 border-0">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">📋 ห้องที่ใช้งานเครื่องดนตรีนี้</h6>

                                    @if($instrument->rooms && $instrument->rooms->count())
                                        <ul class="list-group list-group-flush">
                                            @foreach($instrument->rooms as $room)
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                    
                                                    <div class="d-flex align-items-center gap-2">
                                                        <strong>{{ $room->name }}</strong> 
                                                        ({{ $room->capacity }} คน)
                                                        <span class="badge bg-primary ms-2">จำนวน: {{ $room->pivot->quantity }}</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        {{-- แก้ไขจำนวน --}}
                                                        <form action="{{ route('admin.instruments.updateRoom', [$instrument->instrument_id, $room->room_id]) }}" method="POST" class="d-flex align-items-center gap-1 m-0">
                                                            @csrf
                                                            <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $room->pivot->quantity }}" min="1" style="width: 60px; height: 32px;">
                                                            <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="height: 32px; width: 32px;">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                        </form>

                                                        {{-- ลบห้อง --}}
                                                        <form action="{{ route('admin.instruments.detachRoom', [$instrument->instrument_id, $room->room_id]) }}" method="POST" onsubmit="return confirm('แน่ใจว่าต้องการลบห้องนี้ออก?');" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="height: 32px; width: 32px;">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted mb-0">❌ ยังไม่มีห้องที่ใช้เครื่องดนตรีนี้</p>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection

{{-- JavaScript: เปิด modal ถ้ามี errors ของ bag instrumentRoom + เปิด tooltip --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // เปิด modal ถ้ามี errors ของ bag instrumentRoom
    @foreach($instruments as $instrument)
        @if($errors->hasBag('instrumentRoom') && old('instrument_id') == $instrument->instrument_id)
            var modalEl = document.getElementById('roomsModal{{ $instrument->instrument_id }}');
            if(modalEl){
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        @endif
    @endforeach

    // เปิด tooltip สำหรับปุ่ม
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

});
</script>

