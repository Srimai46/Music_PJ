<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Room;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // ----------------------- Promotions -----------------------
        $promotions = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        // ----------------------- Rooms + Filter -----------------------
        $query = Room::with('instruments'); // eager load instruments

        // Search by room name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by capacity
        if ($request->capacity) {
            if ($request->capacity === '1-3') {
                $query->whereBetween('capacity', [1, 3]);
            } elseif ($request->capacity === '4-6') {
                $query->whereBetween('capacity', [4, 6]);
            } elseif ($request->capacity === '7+') {
                $query->where('capacity', '>=', 7);
            }
        }

        // Filter by price
        if ($request->price) {
            if ($request->price === 'low') {
                $query->where('price_per_hour', '<', 200);
            } elseif ($request->price === 'mid') {
                $query->whereBetween('price_per_hour', [200, 500]);
            } elseif ($request->price === 'high') {
                $query->where('price_per_hour', '>', 500);
            }
        }

        // ดึงข้อมูลหลัง filter
        $rooms = $query->get();

        return view('guest.home', compact('promotions', 'rooms'));
    }
}
