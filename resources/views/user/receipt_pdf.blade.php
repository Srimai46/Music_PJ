<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $receipt->receipt_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; margin: auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .list { width: 100%; border-collapse: collapse; }
        .list td, .list th { border: 1px solid #ddd; padding: 8px; }
        .list th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Receipt</h2>
        </div>

        <div class="section">
            <strong>Receipt Number:</strong> {{ $receipt->receipt_number }}<br>
            <strong>Booking Number:</strong> {{ $booking->booking_id }}<br>
            <strong>Status:</strong> {{ ucfirst($booking->status) }}<br>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('d M Y H:i') }}
        </div>

        <div class="section">
            <h4>Room Info</h4>
            <p>{{ $booking->room->name }}</p>
            <p>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</p>
        </div>

        @if($addons->count())
        <div class="section">
            <h4>Add-ons</h4>
            <table class="list">
                <tr>
                    <th>Instrument</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
                @foreach($addons as $addon)
                <tr>
                    <td>{{ $addon->instrument->name }}</td>
                    <td>{{ $addon->quantity }}</td>
                    <td>{{ number_format($addon->price * $addon->quantity,2) }} ฿</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        <div class="section">
            <h4>Payment Details</h4>
            <table class="list">
                <tr>
                    <td>Total Amount</td>
                    <td>{{ number_format($receipt->full_amount, 2) }} ฿</td>
                </tr>
                <tr>
                    <td>Deposit Paid</td>
                    <td>{{ number_format($receipt->deposit_amount, 2) }} ฿</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{ number_format($receipt->discount_amount, 2) }} ฿</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
