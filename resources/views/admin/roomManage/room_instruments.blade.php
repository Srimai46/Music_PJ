@extends('layout.adminlayout')

@section('title', 'Room Instruments')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">🎵 เครื่องดนตรีในห้อง: {{ $room->name }}</h2>

    {{-- ข้อความสำเร็จ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มเพิ่มเครื่องดนตรี --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-light fw-bold">เพิ่มเครื่องดนตรีในห้อง</div>
        <div class="card-body">
            <form action="{{ route('admin.rooms.addInstrument', $room->room_id) }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <select name="instrument_id" class="form-select" required>
                            <option value="">เลือกเครื่องดนตรี</option>
                            @foreach($instruments as $inst)
                                <option value="{{ $inst->instrument_id }}">{{ $inst->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantity" class="form-control" placeholder="จำนวน" min="1" required>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> เพิ่ม
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ตารางเครื่องดนตรี --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light fw-bold">รายการเครื่องดนตรี</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th>รูป</th>
                            <th>เครื่องดนตรี</th>
                            <th>จำนวน</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($room->instruments as $inst)
                        <tr>
                            <td>
                                @if($inst->picture_url)
                                    <img src="{{ asset('storage/' . $inst->picture_url) }}" width="60" class="img-thumbnail rounded">
                                @else
                                    <span class="text-muted small">ไม่มีรูป</span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $inst->name }}</td>
                            <td>
                                <form action="{{ route('admin.rooms.updateInstrument', [$room->room_id, $inst->instrument_id]) }}" method="POST" class="d-flex justify-content-center">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $inst->pivot->quantity }}" min="1" class="form-control me-2" style="width:80px;">
                                    <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="อัปเดตจำนวน">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($inst->status=='available') bg-success
                                    @elseif($inst->status=='unavailable') bg-secondary
                                    @elseif($inst->status=='maintenance') bg-warning text-dark
                                    @endif
                                ">
                                    {{ ucfirst($inst->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.rooms.detachInstrument', [$room->room_id, $inst->instrument_id]) }}" method="POST" onsubmit="return confirm('ลบเครื่องดนตรีออกจากห้อง?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="ลบเครื่องดนตรี">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted py-3">ยังไม่มีเครื่องดนตรีในห้องนี้</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
