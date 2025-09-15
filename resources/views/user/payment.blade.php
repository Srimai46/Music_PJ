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

                        {{-- แสดง Add-ons ข้างล่างแบบ glass card --}}
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

                <form action="{{ route('user.room.qrcode', $room->room_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="hours" value="{{ $hours }}">
                    <input type="hidden" name="start_time" value="{{ $start_time }}">
                    <input type="hidden" name="end_time" value="{{ $end_time }}">
                    <input type="hidden" name="final_total" value="{{ $final_total }}">
                    <input type="hidden" name="addons" value='@json($addons)'>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Pay → QR Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
