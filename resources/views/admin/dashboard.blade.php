@extends('layout.adminlayout')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">
    <i class="bi bi-speedometer2 me-2"></i> สรุปภาพรวมระบบ
</h2>

<!-- Success Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm glass-card" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mb-4">
    <!-- Users -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-people-fill fs-3 text-primary mb-2"></i>
                <h6 class="card-title">Users</h6>
                <h4>{{ $totalUsers }}</h4>
            </div>
        </div>
    </div>

    <!-- Rooms -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-door-open-fill fs-3 text-success mb-2"></i>
                <h6 class="card-title">Rooms</h6>
                <h4>{{ $totalRooms }}</h4>
            </div>
        </div>
    </div>

    <!-- Instruments -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-music-note-beamed fs-3 text-warning mb-2"></i>
                <h6 class="card-title">Instruments</h6>
                <h4>{{ $totalInstruments }}</h4>
            </div>
        </div>
    </div>

    <!-- Bookings -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-calendar-check-fill fs-3 text-info mb-2"></i>
                <h6 class="card-title">Bookings</h6>
                <h4>{{ $totalBookings }}</h4>
            </div>
        </div>
    </div>

    <!-- Payments -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-credit-card-2-front-fill fs-3 text-danger mb-2"></i>
                <h6 class="card-title">Payments</h6>
                <h4>{{ number_format($totalPayments,2) }} ฿</h4>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="col-md-2 mb-3">
        <div class="card glass-card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-hourglass-split fs-3 text-secondary mb-2"></i>
                <h6 class="card-title">Pending Payments</h6>
                <h4>{{ $pendingPayments ?? 0 }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- Today's Bookings -->
<div class="card glass-card shadow-sm mb-4">
    <div class="card-header border-0 bg-transparent">
        <h5><i class="bi bi-calendar-day me-2"></i> การจองห้องวันนี้ ({{ now()->format('d/m/Y') }})</h5>
    </div>
    <div class="card-body">
        @if ($todayBookings->count() > 0)
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Room</th>
                        <th>User</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todayBookings as $booking)
                        <tr>
                            <td>{{ $booking->room->name ?? 'N/A' }}</td>
                            <td>{{ $booking->user->firstname . ' ' . $booking->user->lastname }}</td>
                            <td>{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                            <td>
                                @if($booking->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif($booking->status === 'complete')
                                    <span class="badge bg-primary">Complete</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="complete" {{ $booking->status == 'complete' ? 'selected' : '' }}>Complete</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">ไม่มีการจองห้องวันนี้</p>
        @endif
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Monthly Bookings Line Chart -->
    <div class="col-md-6 mb-3">
        <div class="card glass-card shadow-sm">
            <div class="card-header border-0 bg-transparent">
                <h5><i class="bi bi-graph-up me-2"></i> การจองรายเดือน</h5>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Booking Status Pie Chart -->
    <div class="col-md-6 mb-3">
        <div class="card glass-card shadow-sm">
            <div class="card-header border-0 bg-transparent">
                <h5><i class="bi bi-pie-chart-fill me-2"></i> สถานะการจอง</h5>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Revenue & Top Rooms Row -->
<div class="row mb-4">
    <!-- Monthly Revenue Chart -->
    <div class="col-md-6 mb-3">
        <div class="card glass-card shadow-sm">
            <div class="card-header border-0 bg-transparent">
                <h5><i class="bi bi-cash-coin me-2"></i> รายได้รายเดือน</h5>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Rooms Bar Chart -->
    <div class="col-md-6 mb-3">
        <div class="card glass-card shadow-sm">
            <div class="card-header border-0 bg-transparent">
                <h5><i class="bi bi-award-fill me-2"></i> ห้องยอดนิยม</h5>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="topRoomsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Logs -->
<div class="card glass-card shadow-sm mb-4">
    <div class="card-header border-0 bg-transparent">
        <h5><i class="bi bi-journal-text me-2"></i> Recent Activity Logs</h5>
    </div>
    <div class="card-body">
        @if ($recentLogs->count() > 0)
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentLogs as $log)
                        <tr>
                            <td>{{ $log->user->username ?? 'N/A' }}</td>
                            <td>{{ ucfirst($log->role) }}</td>
                            <td>{{ $log->action_type }}</td>
                            <td>{{ $log->details }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">ไม่มีกิจกรรมล่าสุด</p>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Booking Line Chart
    new Chart(document.getElementById('bookingChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'จำนวนการจอง',
                data: @json($chartData),
                fill: true,
                backgroundColor: 'rgba(78, 115, 223, 0.4)',
                borderColor: 'rgba(78, 115, 223, 1)',
                tension: 0.3,
                pointRadius: 5
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Booking Status Pie Chart
    new Chart(document.getElementById('statusChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Pending', 'Confirmed', 'Cancelled'],
            datasets: [{
                data: @json($bookingStatusCountsArray),
                backgroundColor: ['#f6c23e','#1cc88a','#e74a3b']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Monthly Revenue Chart
    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'รายได้ (฿)',
                data: @json($monthlyRevenue),
                backgroundColor: 'rgba(28, 200, 138, 0.7)'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Top Rooms Chart
    new Chart(document.getElementById('topRoomsChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($topRoomsNames),
            datasets: [{
                label: 'จำนวนการจอง',
                data: @json($topRoomsCounts),
                backgroundColor: 'rgba(54, 185, 204, 0.7)'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>

<!-- Custom Glassmorphism Style -->
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.25);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}
</style>
@endsection
