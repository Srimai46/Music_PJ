@extends('layout.adminlayout')
@section('title', 'Add Promotion')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary fw-bold">เพิ่มโปรโมชั่น</h2>

    {{-- แสดง Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow border-0 rounded-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card glass-card shadow-sm p-4">
        <form action="{{ route('admin.promotions.store') }}" method="POST">
            @csrf

            {{-- Promotion Name --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">ชื่อโปรโมชั่น</label>
                <input type="text" name="name" class="form-control" placeholder="ชื่อโปรโมชั่น" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">รายละเอียด</label>
                <textarea name="description" class="form-control" placeholder="รายละเอียดโปรโมชั่น" rows="3"></textarea>
            </div>

            {{-- Discount Type & Value --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ประเภทส่วนลด</label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percent">Percent</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">มูลค่าส่วนลด</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="discount_value" class="form-control" placeholder="เช่น 10.00" required>
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                    </div>
                </div>
            </div>

            {{-- Start & End Date --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">วันที่เริ่มต้น</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">วันที่สิ้นสุด</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bi bi-plus-lg"></i> เพิ่มโปรโมชั่น
                </button>
                <a href="{{ route('admin.promotions') }}" class="btn btn-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-x-lg"></i> ยกเลิก
                </a>
            </div>
        </form>
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
    background: rgba(255, 255, 255, 0.75);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.input-group-text i {
    font-size: 1rem;
}
</style>
@endpush
@endsection
