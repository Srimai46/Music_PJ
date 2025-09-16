@extends('layout.adminlayout')
@section('title', 'Instrument Categories')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">ประเภทเครื่องดนตรี</h2>

    {{-- แสดง Validation Error --}}
    @if ($errors->any() && ! $errors->hasBag('instrumentRoom'))
        <div class="alert alert-danger alert-dismissible fade show shadow border-0 rounded-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- แสดง Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow border-0 rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ฟอร์มเพิ่มประเภท --}}
    <div class="card glass-card border-0 mb-4">
        <div class="card-body d-flex">
            <form id="addCategoryForm" action="{{ route('admin.instrumentCategories.store') }}" method="POST" class="flex-grow-1 me-2">
                @csrf
                <input type="text" name="name" class="form-control" placeholder="เพิ่มประเภทเครื่องดนตรีใหม่..." required>
            </form>
            <button type="submit" form="addCategoryForm" class="btn btn-success me-2">
                <i class="bi bi-plus-lg"></i> เพิ่ม
            </button>
            <button id="deleteSelected" type="button" class="btn btn-danger">
                <i class="bi bi-trash"></i> ลบที่เลือก
            </button>
        </div>
    </div>

    {{-- แสดง Grid --}}
    <div class="row row-cols-2 row-cols-md-4 g-4">
        @foreach($categories as $category)
        <div class="col">
            <div class="card glass-card h-100 border-0 shadow-sm text-center p-4 category-card position-relative">
                
                {{-- Checkbox ขวาบน --}}
                <div class="form-check position-absolute top-0 end-0 m-2">
                    <input class="form-check-input category-checkbox" type="checkbox" value="{{ $category->category_id }}" onclick="event.stopPropagation();">
                </div>

                {{-- ลิงก์เข้าห้องเครื่องดนตรี --}}
                <a href="{{ url('/instruments/'.$category->category_id) }}" class="text-decoration-none text-dark d-block mt-4">
                    {{-- Icon --}}
                    <div class="fs-1 mb-3 text-primary">
                        @php
                        $icon = match(strtolower($category->name)) {
                            'กลอง' => 'fa-solid fa-drum',
                            'กีตาร์' => 'fa-solid fa-guitar',
                            'คีย์บอร์ด' => 'fa-solid fa-music',
                            'ไวโอลิน' => 'fa-solid fa-music',
                            default => 'fa-solid fa-music'
                        };
                        @endphp
                        <i class="{{ $icon }} fs-1 text-primary"></i>
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
    /* Glassmorphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 16px;
        transition: all 0.2s ease-in-out;
    }

    .category-card {
        cursor: pointer;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
{{-- SweetAlert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('deleteSelected').addEventListener('click', () => {
    const selectedCheckboxes = document.querySelectorAll('.category-checkbox:checked');
    if(selectedCheckboxes.length === 0){
        Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน',
            text: 'โปรดเลือกอย่างน้อย 1 ประเภทที่ต้องการลบ',
            confirmButtonColor: '#0d6efd'
        });
        return;
    }

    Swal.fire({
        title: 'ยืนยันการลบ',
        text: 'คุณแน่ใจว่าต้องการลบประเภทที่เลือก?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if(result.isConfirmed){
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
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        text: 'ประเภทที่เลือกถูกลบเรียบร้อยแล้ว',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'กรุณาลองใหม่'
                    });
                }
            });
        }
    });
});
</script>
@endpush
@endsection
