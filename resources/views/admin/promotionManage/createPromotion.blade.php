@extends('layout.adminlayout')
@section('title', 'Add Promotion')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">เพิ่มโปรโมชั่น</h2>

    {{-- แสดง error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('admin.promotions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">ชื่อโปรโมชั่น</label>
                <input type="text" name="name" class="form-control" placeholder="ชื่อโปรโมชั่น" required>
            </div>

            <div class="mb-3">
                <label class="form-label">รายละเอียด</label>
                <textarea name="description" class="form-control" placeholder="รายละเอียดโปรโมชั่น" rows="3"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ประเภทส่วนลด</label>
                    <select name="discount_type" class="form-select" required>
                        <option value="percent">Percent</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">มูลค่าส่วนลด</label>
                    <input type="number" step="0.01" min="0" name="discount_value" class="form-control" placeholder="เช่น 10.00" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">วันที่เริ่มต้น</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">วันที่สิ้นสุด</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">เพิ่มโปรโมชั่น</button>
                <a href="{{ route('admin.promotions') }}" class="btn btn-secondary">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>
@endsection
