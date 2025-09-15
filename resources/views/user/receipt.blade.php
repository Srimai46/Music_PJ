@extends('layout.userlayout')

@section('title', 'Receipt')

@section('content')
<div class="container py-5">
    <div class="card p-4 shadow-sm" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px;">
        <h3 class="mb-4">Receipt</h3>

        <div class="mb-3">
            <strong>Receipt Number:</strong> {{ $receipt->receipt_number }}<br>
            <strong>Booking Number:</strong> {{ $booking->booking_id }}<br>
            <strong>Status:</strong> {{ ucfirst($booking->status) }}<br>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y H:i') }}
        </div>

        <hr>

        <h5>Room Info</h5>
        <p><i class="bi bi-house-door-fill me-2"></i>{{ $booking->room->name }}</p>
        <p><i class="bi bi-clock-fill me-2"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</p>

        @if($addons->count())
        <h5 class="mt-3">Add-ons</h5>
        <ul class="list-group mb-3">
            @foreach($addons as $addon)
                <li class="list-group-item d-flex justify-content-between align-items-center" style="background: rgba(255,255,255,0.1); border: none;">
                    {{ $addon->instrument->name }} x{{ $addon->quantity }}
                    <span>{{ number_format($addon->price * $addon->quantity, 2) }} ฿</span>
                </li>
            @endforeach
        </ul>
        @endif

        <h5>Payment Details</h5>
        <ul class="list-group mb-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
            <li class="list-group-item d-flex justify-content-between" style="background: transparent; border: none;">
                Total Amount
                <span>{{ number_format($receipt->full_amount, 2) }} ฿</span>
            </li>
            <li class="list-group-item d-flex justify-content-between" style="background: transparent; border: none;">
                Deposit Paid
                <span>{{ number_format($receipt->deposit_amount, 2) }} ฿</span>
            </li>
            <li class="list-group-item d-flex justify-content-between" style="background: transparent; border: none;">
                Discount
                <span>{{ number_format($receipt->discount_amount, 2) }} ฿</span>
            </li>
        </ul>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('user.bookings') }}" class="btn btn-secondary">Back to Bookings</a>
            <a href="{{ route('user.room.receipt.pdf', $booking->booking_id) }}" class="btn btn-primary">Download PDF</a>
        </div>
    </div>
</div>
@endsection
