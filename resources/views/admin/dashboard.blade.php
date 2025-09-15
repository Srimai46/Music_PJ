@extends('layout.adminlayout')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">📊 สรุปภาพรวมระบบ</h2>

    <div class="row">
        <!-- Users -->
        <div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <!-- Rooms -->
        <div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>
                    <h3>{{ $totalRooms }}</h3>
                </div>
            </div>
        </div>

        <!-- Instruments -->
        <div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Instruments</h5>
                    <h3>{{ $totalInstruments }}</h3>
                </div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Bookings</h5>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-3 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="card-title">Payments</h5>
                    <h3>{{ number_format($totalPayments, 2) }} ฿</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Today Bookings -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5>📅 การจองห้องวันนี้ ({{ now()->format('d/m/Y') }})</h5>
        </div>
        <div class="card-body">
            @if ($todayBookings->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>User</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todayBookings as $booking)
                            <tr>
                                <td>{{ $booking->room->name ?? 'N/A' }}</td>
                                <td>{{ $booking->user->firstname . ' ' . $booking->user->lastname }}</td>
                                <td>{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">ไม่มีการจองห้องวันนี้</p>
            @endif
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5>📈 การจองรายเดือน</h5>
        </div>
        <div class="card-body" style="height: 250px;">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookingChart').getContext('2d');

        new Chart(ctx, {
            type: 'line', // ✅ ใช้ line chart
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'จำนวนการจองรายเดือน (12 เดือนล่าสุด)',
                    data: @json($chartData),
                    fill: true, // ✅ ให้มีพื้นหลัง
                    backgroundColor: 'rgba(255, 99, 132, 0.4)', // สีพื้นหลัง
                    borderColor: 'rgba(255, 99, 132, 1)', // สีเส้น
                    tension: 0.3, // ความโค้งของเส้น
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // ✅ ใช้ความสูงที่กำหนดเอง
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                }
            }
        });
    </script>
    </div>
    </div>

    
@endsection
