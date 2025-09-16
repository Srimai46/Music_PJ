@extends('layout.userlayout')

@section('title', 'Payment')

@section('content')
<div class="container py-5">
    <h2 class="mb-3">Payment</h2>

    <div class="card shadow-sm border-0 p-4">
        <div class="row g-4">
            <div class="col-md-5">
                <img src="{{ $room->image_url ? asset('storage/'.$room->image_url) : 'https://shorturl.at/YT5O1' }}" 
                     class="img-fluid rounded shadow-sm" alt="{{ $room->name }}">
            </div>
            <div class="col-md-7">
                <h4 class="fw-bold">{{ $room->name }}</h4>
                <p>
                    Duration: <strong>{{ $hours }} ชั่วโมง</strong>
                    ({{ \Carbon\Carbon::parse($start_time)->format('d/m/Y H:i') }} 
                     - 
                     {{ \Carbon\Carbon::parse($end_time)->format('d/m/Y H:i') }})
                </p>

                {{-- ราคา --}}
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Room Price</span>
                        <strong>{{ number_format($base_total,2) }} ฿</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-column align-items-start">
                        <div class="d-flex justify-content-between w-100">
                            <span>Add-ons</span>
                            <strong>{{ number_format($addon_total,2) }} ฿</strong>
                        </div>
                        @if(!empty($addons))
                        <div class="mt-2 w-100 p-3 rounded-3" 
                             style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);">
                            <ul class="list-group list-group-flush">
                                @foreach($addons as $addon)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" 
                                        style="background: transparent; border: none; padding: 0.35rem 0;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-music-note"></i>
                                            <span>
                                                Instrument ID: {{ $addon['id'] ?? ($addon['instrument_id'] ?? 'N/A') }}
                                                (Qty: {{ $addon['quantity'] ?? ($addon['qty'] ?? 0) }})
                                            </span>
                                        </div>
                                        @if(isset($addon['price']))
                                            <strong class="text-end">
                                                {{ number_format($addon['price'] * ($addon['quantity'] ?? ($addon['qty'] ?? 0)), 2) }} ฿
                                            </strong>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Total</span>
                        <strong>{{ number_format($final_total,2) }} ฿</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                        <span>Deposit (50%)</span>
                        <strong>{{ number_format($deposit,2) }} ฿</strong>
                    </li>
                </ul>

                <form id="paymentForm" action="{{ route('user.room.qrcode', $room->room_id) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="hours" value="{{ $hours }}">
                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                    <input type="hidden" name="final_total" value="{{ $final_total }}">
                    <input type="hidden" name="addons" value='@json($addons)'>

                    <div class="d-flex gap-3">
                        {{-- Cancel --}}
                        <a href="{{ route('user.home') }}" 
                           class="btn btn-outline-secondary btn-lg flex-fill d-flex align-items-center justify-content-center rounded-3 shadow-sm btn-cancel">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>

                        {{-- Pay เปิด modal --}}
                        <button type="button" 
                                class="btn btn-lg flex-fill d-flex align-items-center justify-content-center rounded-3 shadow-sm btn-pay"
                                data-bs-toggle="modal" data-bs-target="#termsModal">
                            <i class="bi bi-credit-card me-2"></i> Pay → QR Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Terms & Conditions Modal --}}
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" 
         style="backdrop-filter: blur(12px); background: rgba(255,255,255,0.95); border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
      
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body p-4" style="font-size: 0.95rem; color: #333;">
        <ul class="mb-3" style="line-height: 1.6;">
            <li>Payment is 50% deposit of total amount.</li>
            <li>Once payment is made, booking cannot be canceled.</li>
            <li>Please arrive on time for your booking.</li>
            <li>Any damages or missing instruments are the responsibility of the user.</li>
            <li>Check your booking details carefully before proceeding.</li>
        </ul>
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" id="acceptTerms">
            <label class="form-check-label fw-semibold" for="acceptTerms">
                I accept the terms & conditions
            </label>
        </div>
      </div>
      
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" class="btn btn-primary rounded-3 px-4" id="confirmPayBtn" disabled>
            Confirm
        </button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    const termsModal = document.getElementById('termsModal');

    termsModal.addEventListener('shown.bs.modal', function () {
        const checkbox = termsModal.querySelector('#acceptTerms');
        const confirmBtn = termsModal.querySelector('#confirmPayBtn');

        confirmBtn.disabled = true; // เริ่มปิดปุ่ม

        // ใช้ onchange แทน click
        checkbox.onchange = function() {
            confirmBtn.disabled = !this.checked;
        };

        confirmBtn.onclick = function() {
            paymentForm.submit();
        };
    });
});
</script>
@endsection
