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
                        <a href="{{ route('user.bookings.edit', $b->booking_id) }}" class="btn btn-sm btn-primary">Edit</a>
                        @if($b->status != 'cancelled')
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $b->booking_id }}">
                                Cancel
                            </button>

                            <!-- Cancel Modal -->
                            <div class="modal fade" id="cancelModal{{ $b->booking_id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancel Booking #{{ $b->booking_id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>คุณยืนยันที่จะยกเลิกการจองนี้?</p>
                                            <p>เงื่อนไขคืนเงิน: 
                                            @php
                                                $hoursBefore = \Carbon\Carbon::parse($b->start_time)->diffInHours(now(), false);
                                                $refund = ($hoursBefore >= 24) ? 80 : 50;
                                            @endphp
                                            คืนเงิน {{ $refund }}%</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('user.bookings.cancel', $b->booking_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">ยืนยันการยกเลิก</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('user.bookings.destroy', $b->booking_id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบการจองนี้? การลบจะลบข้อมูล Add-ons, Payment, Receipt ทั้งหมดด้วย!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $bookings->links() }}
@endif
@endsection
