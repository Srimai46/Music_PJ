@extends('layout.adminlayout')
@section('title', 'Promotion Management')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">Promotion Management</h2>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow border-0 rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Add Promotion Button --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i> เพิ่มโปรโมชั่น
        </a>
    </div>

    {{-- Promotion Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center glass-table">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th class="text-start">ชื่อโปรโมชั่น</th>
                    <th>ประเภทส่วนลด</th>
                    <th>มูลค่าส่วนลด</th>
                    <th>วันที่เริ่มต้น</th>
                    <th>วันที่สิ้นสุด</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promotions as $promotion)
                <tr class="glass-row">
                    <td>{{ $promotion->promo_id }}</td>
                    <td class="text-start">{{ $promotion->name }}</td>
                    <td>{{ ucfirst($promotion->discount_type) }}</td>
                    <td>{{ $promotion->discount_value }}</td>
                    <td>{{ \Carbon\Carbon::parse($promotion->start_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $promotion->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $promotion->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            {{-- Edit --}}
                            <a href="{{ route('admin.promotions.edit', $promotion->promo_id) }}" 
                               class="btn btn-sm btn-warning d-flex align-items-center justify-content-center" 
                               style="width:35px; height:35px;" data-bs-toggle="tooltip" title="แก้ไข">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.promotions.delete', $promotion->promo_id) }}" method="POST" 
                                  onsubmit="return confirm('คุณแน่ใจว่าจะลบโปรโมชั่นนี้?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center" 
                                        style="width:35px; height:35px;" data-bs-toggle="tooltip" title="ลบ">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                            {{-- Toggle Active --}}
                            <form action="{{ route('admin.promotions.toggle', $promotion->promo_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center {{ $promotion->is_active ? 'btn-secondary' : 'btn-success' }}" 
                                        style="width:35px; height:35px;" data-bs-toggle="tooltip" title="{{ $promotion->is_active ? 'ปิดใช้งาน' : 'เปิดใช้งาน' }}">
                                    <i class="bi {{ $promotion->is_active ? 'bi-x-circle-fill' : 'bi-check-circle-fill' }}"></i>
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

@push('styles')
<style>
/* Glassmorphism effect */
.glass-table {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 12px;
}

.glass-row:hover {
    background: rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.2s ease-in-out;
}

.table th, .table td {
    vertical-align: middle;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
