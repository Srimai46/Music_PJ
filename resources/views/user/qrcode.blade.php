@extends('layout.userlayout')

@section('title', 'QR Code Payment')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg border-0 rounded-4 p-4" 
         style="max-width: 500px; width: 100%; 
                background: rgba(255, 255, 255, 0.15); 
                backdrop-filter: blur(12px); 
                -webkit-backdrop-filter: blur(12px); 
                border: 1px solid rgba(255, 255, 255, 0.3);">

        <!-- Header -->
        <div class="text-center mb-4">
            <i class="bi bi-qr-code fs-1 text-primary"></i>
            <h3 class="fw-bold mt-2">QR Code Payment</h3>
            <p class="text-muted">Please scan the QR code to pay your deposit</p>
        </div>

        <!-- QR Code -->
        <div class="text-center mb-4">
            <img src="https://shorturl.at/9w5cL" 
                 alt="QR Code" 
                 class="img-fluid rounded shadow-sm border" 
                 style="max-width: 250px;">
        </div>

        <!-- Deposit -->
        <div class="alert alert-info fw-bold text-center mb-4 rounded-3">
            Deposit to Pay: <span class="text-dark">{{ number_format($deposit, 2) }} ฿</span>
        </div>

        <!-- Countdown -->
        <div class="text-center mb-3">
            <i class="bi bi-hourglass-split text-danger"></i>
            <p id="countdown" class="text-danger fw-bold fs-5 mb-0">03:00</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('user.room.confirmPayment', $room->room_id) }}" class="d-grid">
            @csrf
            <input type="hidden" name="hours" value="{{ $hours }}">
            <input type="hidden" name="start_time" value="{{ $start_time }}">
            <input type="hidden" name="end_time" value="{{ $end_time }}">
            <input type="hidden" name="final_total" value="{{ $final_total }}">
            @foreach($addons as $addon)
                <input type="hidden" name="addons[{{ $addon['instrument_id'] }}]" value="{{ $addon['quantity'] }}">
            @endforeach

            <button type="submit" class="btn btn-success btn-lg rounded-3 shadow-sm">
                <i class="bi bi-check-circle me-2"></i> Confirm Payment
            </button>
        </form>
    </div>
</div>

<!-- Countdown Script -->
<script>
    let timeLeft = 180;
    const countdownEl = document.getElementById('countdown');

    const timer = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        countdownEl.textContent = 
            `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;

        if (timeLeft <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('user.home') }}"; // redirect
        }

        timeLeft--;
    }, 1000);
</script>
@endsection
