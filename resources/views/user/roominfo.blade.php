@extends('layout.userlayout')

@section('title', 'Room Info')

@section('content')
<div class="container py-5">
    <h2 class="mb-3">{{ $room->name }}</h2>
    <p>Price: {{ number_format($room->price_per_hour,2) }} ฿ / hour</p>
    <p>Capacity: {{ $room->capacity }}</p>

    <!-- ตารางเวลาที่ถูกจอง -->
    <h5 class="mt-4">Existing Bookings</h5>
    <ul>
        @foreach($bookings as $b)
            <li>
                {{ \Carbon\Carbon::parse($b->start_time)->format('d/m/Y H:i') }} → 
                {{ \Carbon\Carbon::parse($b->end_time)->format('d/m/Y H:i') }}
            </li>
        @endforeach
    </ul>

    <!-- ฟอร์มเลือกวันเวลา -->
    <form id="availabilityForm">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control">
            </div>
            <div class="col-md-6">
                <label>End Time</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>
        </div>
        <button type="button" id="checkBtn" class="btn btn-primary">Check Availability</button>
    </form>

    <div id="priceResult" class="mt-4"></div>
</div>

<script>
document.getElementById('checkBtn').addEventListener('click', function() {
    let form = document.getElementById('availabilityForm');
    let data = new FormData(form);

    fetch("{{ route('user.room.checkAvailability', $room->room_id) }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if(data.conflict) {
            alert("❌ ห้องนี้ถูกจองแล้วในช่วงเวลาที่เลือก");
        } else {
            document.getElementById('priceResult').innerHTML = `
                <p>Hours: ${data.hours}</p>
                <p>Price: ${data.price} ฿</p>
                <p>Discount: ${data.discount.toFixed(2)} ฿</p>
                <p><strong>Total: ${data.total.toFixed(2)} ฿</strong></p>
                <a href="{{ route('user.room.addons', $room->room_id) }}?hours=${data.hours}&total=${data.total}&start_time=${form.start_time.value}&end_time=${form.end_time.value}" class="btn btn-success mt-2">Next → Add-ons</a>
            `;
        }
    });
});
</script>
@endsection
