@extends('layout.userlayout')

@section('title', 'Edit Booking')

@section('content')
<div class="container py-5">
    <h3>Edit Booking #{{ $booking->booking_id }}</h3>
    
    <div class="card p-4 shadow-sm">
        <h5>Room: {{ $booking->room->name }}</h5>
        <p>Price per hour: {{ number_format($booking->room->price_per_hour, 2) }} ฿</p>
        <p>Total Price: {{ number_format($booking->total_price, 2) }} ฿</p>
        <p>Status: <strong>{{ ucfirst($booking->status) }}</strong></p>

        <form action="{{ route('user.bookings.update', $booking->booking_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                    value="{{ old('start_time', \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i')) }}" required>
                @error('start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                    value="{{ old('end_time', \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i')) }}" required>
                @error('end_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- สำหรับ conflict error --}}
            @if($errors->has('time_conflict'))
                <div class="alert alert-danger mt-2">
                    {{ $errors->first('time_conflict') }}
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update Booking</button>
            <a href="{{ route('user.bookings') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
