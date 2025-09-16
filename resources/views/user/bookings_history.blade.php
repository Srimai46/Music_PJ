@extends('layout.userlayout')

@section('title', 'My Bookings')

@section('content')
<h3 class="mb-4">My Bookings</h3>

@if($bookings->isEmpty())
    <div class="alert alert-info text-center">คุณยังไม่มีการจองห้องซ้อมดนตรี</div>
@else
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                <tr>
                    <td>{{ $b->booking_id }}</td>
                    <td>{{ $b->room->name }}</td>
                    <td>{{ $b->start_time }}</td>
                    <td>{{ $b->end_time }}</td>
                    <td>{{ number_format($b->total_price,2) }}</td>
                    <td>{{ ucfirst($b->status) }}</td>
                    <td>
                        @php
                            $hoursBefore = \Carbon\Carbon::parse($b->start_time)->diffInHours(now(), false);
                            $refund = ($hoursBefore >= 24) ? 80 : 50;
                        @endphp

                        <button class="btn btn-sm btn-danger cancel-btn" 
                                data-id="{{ $b->booking_id }}" 
                                data-refund="{{ $refund }}"
                                @if($b->status == 'cancelled') disabled style="opacity:0.6;" @endif>
                            Cancel
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $bookings->links() }}
@endif
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.cancel-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.id;
            const refund = this.dataset.refund;
            const btn = this;

            Swal.fire({
                title: `Cancel Booking #${bookingId}?`,
                html: `คุณยืนยันที่จะยกเลิกการจองนี้?<br>เงื่อนไขคืนเงิน: คืนเงิน ${refund}%`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ยืนยันการยกเลิก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ url('/user/my-bookings') }}/" + bookingId + "/cancel", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(response => {
                        if(response.ok){
                            Swal.fire('Cancelled!', 'การจองถูกยกเลิกเรียบร้อยแล้ว.', 'success');
                            btn.disabled = true;
                            btn.style.opacity = 0.6;

                            // เปลี่ยนสถานะในตารางเป็น Cancelled
                            const statusCell = btn.closest('tr').querySelector('td:nth-child(6)');
                            statusCell.textContent = 'Cancelled';
                        } else {
                            Swal.fire('Error', 'เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
                        }
                    }).catch(() => {
                        Swal.fire('Error', 'เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
                    });
                }
            });
        });
    });
});
</script>
@endsection
