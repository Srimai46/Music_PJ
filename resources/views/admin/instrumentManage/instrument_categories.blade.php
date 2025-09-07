@extends('layout.adminlayout')
@section('title', 'Instrument Categories')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">🎼 ประเภทเครื่องดนตรี</h2>

    {{-- แสดง Validation Error --}}
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

    {{-- ฟอร์มเพิ่มประเภท --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex">
            <form id="addCategoryForm" action="{{ route('admin.instrumentCategories.store') }}" method="POST" class="flex-grow-1 me-2">
                @csrf
                <input type="text" name="name" class="form-control" placeholder="เพิ่มประเภทเครื่องดนตรีใหม่..." required>
            </form>
            <button type="submit" form="addCategoryForm" class="btn btn-success me-2">+ เพิ่ม</button>
            <button id="deleteSelected" type="button" class="btn btn-danger">🗑 ลบที่เลือก</button>
        </div>
    </div>

    {{-- แสดง Grid --}}
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($categories as $category)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm text-center p-4 category-card position-relative">
                
                {{-- Checkbox ขวาบน --}}
                <div class="form-check position-absolute top-0 end-0 m-2">
                    <input class="form-check-input category-checkbox" type="checkbox" value="{{ $category->category_id }}" onclick="event.stopPropagation();">
                </div>

                {{-- ลิงก์เข้าห้องเครื่องดนตรี --}}
                <a href="{{ url('/admin/instruments/'.$category->category_id) }}" class="text-decoration-none text-dark d-block mt-4">
                    {{-- Icon --}}
                    <div class="fs-1 mb-3">
                        @php
                        $icon = match(strtolower($category->name)) {
                            'กลอง' => '🥁',
                            'กีตาร์' => '🎸',
                            'คีย์บอร์ด' => '🎹',
                            'ไวโอลิน' => '🎻',
                            default => '🎶'
                        };
                        @endphp
                        {{ $icon }}
                    </div>
                    <h5 class="fw-semibold">{{ $category->name }}</h5>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('styles')
<style>
    .category-card {
        transition: all 0.2s ease-in-out;
        border-radius: 12px;
        cursor: pointer;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('deleteSelected').addEventListener('click', () => {
    const selectedCheckboxes = document.querySelectorAll('.category-checkbox:checked');
    if(selectedCheckboxes.length === 0){
        alert('โปรดเลือกอย่างน้อย 1 ประเภทที่ต้องการลบ');
        return;
    }

    if(!confirm('คุณแน่ใจว่าต้องการลบประเภทที่เลือก?')) return;

    const ids = Array.from(selectedCheckboxes).map(cb => cb.value);

    fetch("{{ route('admin.instrumentCategories.deleteSelected') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    }).then(res => res.json())
    .then(data => {
        if(data.success){
            location.reload();
        } else {
            alert('เกิดข้อผิดพลาด กรุณาลองใหม่');
        }
    });
});
</script>
@endpush
@endsection
