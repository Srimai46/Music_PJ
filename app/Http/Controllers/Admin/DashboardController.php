<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Room;
use App\Models\Instrument;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ สรุปข้อมูล
        $totalUsers = User::count();
        $totalRooms = Room::count();
        $totalInstruments = Instrument::count();
        $totalBookings = Booking::count();
        $totalPayments = Payment::sum('amount');

        // ✅ การจองรายเดือน (เฉพาะปีปัจจุบัน)
        $bookingsByMonthRaw = Booking::selectRaw('MONTH(start_time) as month, COUNT(*) as total')
            ->whereYear('start_time', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // ✅ เตรียม array 12 เดือน (0 ถ้าไม่มีการจอง)
        $bookingsByMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $bookingsByMonth[$i] = $bookingsByMonthRaw[$i] ?? 0;
        }

        // ✅ Label เดือน (ภาษาไทย)
        $monthLabels = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
            5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
            9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
        ];

        // ✅ แปลงข้อมูลให้ Chart.js ใช้
        $chartLabels = [];
        $chartData = [];
        foreach ($bookingsByMonth as $month => $total) {
            $chartLabels[] = $monthLabels[$month];
            $chartData[] = $total;
        }

        // ✅ หาค่าสูงสุดของเดือน
        $maxBookings = max($chartData);

        // ✅ กำหนดสี (เดือนที่มียอดจองสูงสุด = สีแดง)
        $chartBackgroundColors = array_map(
            fn($val) => $val === $maxBookings
                ? 'rgba(255, 99, 132, 0.6)'
                : 'rgba(78, 115, 223, 0.6)',
            $chartData
        );

        // ✅ การจองวันนี้
        $todayBookings = Booking::with(['room', 'user'])
            ->whereDate('start_time', Carbon::today())
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRooms',
            'totalInstruments',
            'totalBookings',
            'totalPayments',
            'todayBookings',
            'chartLabels',
            'chartData',
            'chartBackgroundColors'
        ));
    }
}
