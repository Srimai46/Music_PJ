@extends('layout.userlayout')

@section('title', 'Room Add-On')

@section('content')
<div class="container py-5">
    <h2 class="mb-3">{{ $room->name }} - Add-ons</h2>

    <p>
        Duration: <strong>{{ $hours }} ชั่วโมง</strong>
        ({{ \Carbon\Carbon::parse($start_time)->format('d/m/Y H:i') }}
        - 
        {{ \Carbon\Carbon::parse($end_time)->format('d/m/Y H:i') }})
    </p>
    <p>Base Price: <strong>{{ number_format($total,2) }} ฿</strong></p>

    <form id="addonForm">
        @csrf
        <input type="hidden" name="base_total" value="{{ $total }}">

        <table class="table">
            <thead>
                <tr>
                    <th>Instrument</th>
                    <th>Price / unit</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($instruments as $inst)
                <tr>
                    <td>{{ $inst->name }}</td>
                    <td>{{ number_format($inst->price_per_unit,2) }} ฿</td>
                    <td>
                        <input type="number" name="addons[{{ $inst->instrument_id }}][quantity]" value="0" min="0" class="form-control addon-input" data-id="{{ $inst->instrument_id }}" data-price="{{ $inst->price_per_unit }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div id="priceResult" class="mt-4">
        <p>Add-on Total: 0 ฿</p>
        <p><strong>Final Total: {{ number_format($total,2) }} ฿</strong></p>
    </div>

    <a href="{{ route('user.room.payment', [
            'room' => $room->room_id,
            'base_total' => $total,
            'addon_total' => 0,  {{-- จะอัปเดตด้วย JS --}}
            'final_total' => $total,
            'hours' => $hours,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]) }}" 
    id="confirmBtn" class="btn btn-success">Confirm → Payment</a>
</div>

<script>
function updatePrice() {
    let base_total = {{ $total }};
    let addons = [];
    document.querySelectorAll('.addon-input').forEach(input => {
        let qty = parseInt(input.value) || 0;
        if(qty > 0) {
            addons.push({
                instrument_id: input.dataset.id,
                quantity: qty
            });
        }
    });

    fetch("{{ route('user.room.addons.calculate', $room->room_id) }}", {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Content-Type': 'application/json'},
        body: JSON.stringify({ base_total: base_total, addons: addons })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('priceResult').innerHTML = `
            <p>Add-on Total: ${data.addon_total} ฿</p>
            <p><strong>Final Total: ${Number(data.final_total).toFixed(2)} ฿</strong></p>
        `;
    });
}

document.querySelectorAll('.addon-input').forEach(input => {
    input.addEventListener('input', updatePrice);
});

document.getElementById('confirmBtn').addEventListener('click', function(e) {
    e.preventDefault();

    let base_total = {{ $total }};
    let addon_total = 0;
    let addons = [];

    document.querySelectorAll('.addon-input').forEach(input => {
        let qty = parseInt(input.value) || 0;
        if(qty > 0) {
            addons.push({ id: input.dataset.id, quantity: qty, price: input.dataset.price });
            addon_total += qty * parseFloat(input.dataset.price);
        }
    });

    let final_total = base_total + addon_total;

    // สร้าง query string ไปหน้า payment
    let params = new URLSearchParams({
        base_total: base_total,
        addon_total: addon_total,
        final_total: final_total,
        hours: "{{ $hours }}",
        start_time: "{{ $start_time }}",
        end_time: "{{ $end_time }}",
        addons: JSON.stringify(addons),
    });

    window.location.href = "{{ route('user.room.payment', $room->room_id) }}?" + params.toString();
});
</script>
@endsection
