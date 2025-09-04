@extends('layout.adminlayout')
@section('title', 'Promotion Management')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-primary">Promotion Management</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">+ เพิ่มโปรโมชั่น</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>ชื่อโปรโมชั่น</th>
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
                <tr>
                    <td>{{ $promotion->promo_id }}</td>
                    <td class="text-start">{{ $promotion->name }}</td>
                    <td>{{ ucfirst($promotion->discount_type) }}</td>
                    <td>{{ $promotion->discount_value }}</td>
                    <td>{{ $promotion->start_date }}</td>
                    <td>{{ $promotion->end_date }}</td>
                    <td>
                        <span class="badge {{ $promotion->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $promotion->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            <a href="{{ route('admin.promotions.edit', $promotion->promo_id) }}" class="btn btn-sm btn-warning">แก้ไข</a>

                            <form action="{{ route('admin.promotions.delete', $promotion->promo_id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจว่าจะลบโปรโมชั่นนี้?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                            </form>

                            <form action="{{ route('admin.promotions.toggle', $promotion->promo_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $promotion->is_active ? 'btn-secondary' : 'btn-success' }}">
                                    {{ $promotion->is_active ? 'ปิดใช้งาน' : 'เปิดใช้งาน' }}
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
@endsection
