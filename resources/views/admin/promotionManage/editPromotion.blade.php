@extends('layout.adminlayout')
@section('title', 'Edit Promotion')

@section('content')
<div class="container mt-5">
    {{-- Card Glassmorphism --}}
    <div class="card glass-card shadow-sm p-4">
        <h2 class="card-title mb-4 text-primary fw-bold">แก้ไขโปรโมชั่น</h2>

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

        <form action="{{ route('admin.promotions.update', $promotion->promo_id) }}" method="POST">
            @csrf

            {{-- Promotion Name --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">ชื่อโปรโมชั่น</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">รายละเอียด</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $promotion->description) }}</textarea>
            </div>

            {{-- Discount Type & Value --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ประเภทส่วนลด</label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percent" {{ $promotion->discount_type === 'percent' ? 'selected' : '' }}>Percent</option>
                        <option value="fixed" {{ $promotion->discount_type === 'fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">มูลค่าส่วนลด</label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" name="discount_value" class="form-control" value="{{ old('discount_value', $promotion->discount_value) }}" required>
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                    </div>
                </div>
            </div>

            {{-- Start & End Date --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">วันที่เริ่มต้น</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">วันที่สิ้นสุด</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $promotion->end_date) }}" required>
                </div>
            </div>

            {{-- Active Checkbox --}}
            <div class="form-check mb-4">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $promotion->is_active ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold">เปิดใช้งาน</label>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bi bi-save"></i> บันทึก
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
/* Glassmorphism card */
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

/* Buttons hover */
.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Input group icon */
.input-group-text i {
    font-size: 1rem;
}
</style>
@endpush
@endsection
