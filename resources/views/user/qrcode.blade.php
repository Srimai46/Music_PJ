@extends('layout.userlayout')

@section('title', 'QR Code Payment')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">Scan QR to Pay</h2>

    <!-- QR Code placeholder -->
    <div class="mb-4">
        <img src="https://shorturl.at/9w5cL" alt="QR Code" class="img-fluid">
    </div>

    <p>Deposit to Pay: <strong>{{ number_format($deposit, 2) }} ฿</strong></p>

    <form method="POST" action="{{ route('user.room.confirmPayment', $room->room_id) }}">
        @csrf
        <input type="hidden" name="hours" value="{{ $hours }}">
        <input type="hidden" name="start_time" value="{{ $start_time }}">
        <input type="hidden" name="end_time" value="{{ $end_time }}">
        <input type="hidden" name="final_total" value="{{ $final_total }}">
        @foreach($addons as $addon)
            <input type="hidden" name="addons[{{ $addon['instrument_id'] }}]" value="{{ $addon['quantity'] }}">
        @endforeach

        <button type="submit" class="btn btn-success btn-lg mt-3">Confirm Payment</button>
    </form>
</div>
@endsection
