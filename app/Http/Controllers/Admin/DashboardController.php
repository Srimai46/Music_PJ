<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Room;
use App\Models\Instrument;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // -----------------------------
        // ✅ สรุปข้อมูล (Summary)
        // -----------------------------
        $totalUsers       = User::count();
        $totalRooms       = Room::count();
        $totalInstruments = Instrument::count();
        $totalBookings    = Booking::count();
        $totalPayments    = Payment::sum('amount');

        // -----------------------------
        // ✅ การจองรายเดือน (Bookings per Month)
        // -----------------------------
        $bookingsByMonthRaw = Booking::selectRaw('MONTH(start_time) as month, COUNT(*) as total')
            ->whereYear('start_time', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $bookingsByMonth = $this->fillMissingMonths($bookingsByMonthRaw);

        // Label เดือน (ภาษาไทย)
        $monthLabels = [
            1=>'ม.ค.',2=>'ก.พ.',3=>'มี.ค.',4=>'เม.ย.',
            5=>'พ.ค.',6=>'มิ.ย.',7=>'ก.ค.',8=>'ส.ค.',
            9=>'ก.ย.',10=>'ต.ค.',11=>'พ.ย.',12=>'ธ.ค.'
        ];

        $chartLabels = array_map(fn($m) => $monthLabels[$m], array_keys($bookingsByMonth));
        $chartData   = array_values($bookingsByMonth);

        // สีกราฟ (เดือนยอดสูงสุดเป็นสีแดง)
        $maxBookings = max($chartData);
        $chartBackgroundColors = array_map(
            fn($val) => $val === $maxBookings
                ? 'rgba(255, 99, 132, 0.6)'
                : 'rgba(78, 115, 223, 0.6)',
            $chartData
        );

        // -----------------------------
        // ✅ การจองวันนี้ (Today Bookings)
        // -----------------------------
        $todayBookings = Booking::with(['room', 'user'])
            ->whereDate('start_time', Carbon::today())
            ->get();

        $bookingStatusCounts = [
            'pending'   => $todayBookings->where('status', 'pending')->count(),
            'confirmed' => $todayBookings->where('status', 'confirmed')->count(),
            'cancelled' => $todayBookings->where('status', 'cancelled')->count(),
        ];

        $bookingStatusCountsArray = array_values($bookingStatusCounts);

        // -----------------------------
        // ✅ รายได้รายเดือน (Monthly Revenue)
        // -----------------------------
        $monthlyRevenueRaw = Payment::selectRaw('MONTH(paid_at) as month, SUM(amount) as total')
            ->whereYear('paid_at', now()->year)
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyRevenue = $this->fillMissingMonths($monthlyRevenueRaw);

        // -----------------------------
        // ✅ ห้องยอดนิยม (Top Rooms)
        // -----------------------------
        $topRoomsRaw = Booking::selectRaw('room_id, COUNT(*) as total')
            ->groupBy('room_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topRoomsNames  = $topRoomsRaw->map(fn($r) => $r->room->name ?? 'N/A');
        $topRoomsCounts = $topRoomsRaw->pluck('total');

        // -----------------------------
        // ✅ Logs ล่าสุด (Recent Logs)
        // -----------------------------
        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // -----------------------------
        // ✅ ส่งไป View
        // -----------------------------
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRooms',
            'totalInstruments',
            'totalBookings',
            'totalPayments',
            'todayBookings',
            'chartLabels',
            'chartData',
            'chartBackgroundColors',
            'bookingStatusCountsArray',
            'monthlyRevenue',
            'topRoomsNames',
            'topRoomsCounts',
            'recentLogs'
        ));
    }

    /**
     * เติมค่า 0 ให้เดือนที่ไม่มีข้อมูล
     */
    private function fillMissingMonths(array $data): array
    {
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $data[$i] ?? 0;
        }
        return $result;
    }
}
