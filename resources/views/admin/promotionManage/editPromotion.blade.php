@extends('layout.adminlayout')
@section('title', 'Edit Promotion')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title mb-4">แก้ไขโปรโมชั่น</h2>

            {{-- แสดงข้อความ error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.promotions.update', $promotion->promo_id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ชื่อโปรโมชั่น</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $promotion->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">รายละเอียด</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $promotion->description) }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">ประเภทส่วนลด</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percent" {{ $promotion->discount_type === 'percent' ? 'selected' : '' }}>Percent</option>
                            <option value="fixed" {{ $promotion->discount_type === 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">มูลค่าส่วนลด</label>
                        <input type="number" step="0.01" min="0" name="discount_value" class="form-control" value="{{ old('discount_value', $promotion->discount_value) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">วันที่เริ่มต้น</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $promotion->start_date) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">วันที่สิ้นสุด</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $promotion->end_date) }}" required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $promotion->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">เปิดใช้งาน</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <a href="{{ route('admin.promotions') }}" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
